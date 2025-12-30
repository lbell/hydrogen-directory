/**
 * Hydrogen Directory Block
 *
 * A Gutenberg block for displaying directory entries with customizable layouts.
 */

(function (wp) {
  const { registerBlockType } = wp.blocks;
  const { useBlockProps, InspectorControls } = wp.blockEditor;
  const {
    PanelBody,
    SelectControl,
    ToggleControl,
    RangeControl,
    CheckboxControl,
    Spinner,
    Placeholder,
    BaseControl,
  } = wp.components;
  const { useState, useEffect } = wp.element;
  const { __ } = wp.i18n;
  const apiFetch = wp.apiFetch;

  // Block icon
  const blockIcon = wp.element.createElement(
    "svg",
    {
      width: 24,
      height: 24,
      viewBox: "0 0 24 24",
      xmlns: "http://www.w3.org/2000/svg",
    },
    wp.element.createElement("path", {
      d: "M12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4ZM12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14ZM12 16C14.21 16 16.63 16.83 17.69 18H6.31C7.37 16.83 9.79 16 12 16Z",
      fill: "currentColor",
    })
  );

  registerBlockType("hydrogen-directory/directory", {
    icon: blockIcon,

    edit: function (props) {
      const { attributes, setAttributes } = props;
      const {
        taxonomy,
        terms: selectedTerms,
        style,
        columns,
        showHeaders,
        content,
        excerptLength,
      } = attributes;

      const [preview, setPreview] = useState("");
      const [isLoading, setIsLoading] = useState(true);
      const [taxonomies, setTaxonomies] = useState([]);
      const [availableTerms, setAvailableTerms] = useState([]);

      const blockProps = useBlockProps({
        className: "hydir-block-editor hydir-block-" + style,
      });

      // Fetch available taxonomies on mount
      useEffect(() => {
        apiFetch({ path: "/hydrogen-directory/v1/taxonomies" })
          .then((data) => {
            if (Array.isArray(data) && data.length > 0) {
              const taxOptions = data.map((tax) => ({
                label: tax.label || tax.name,
                value: tax.slug,
              }));
              setTaxonomies(taxOptions);
            } else {
              setTaxonomies([
                { label: __("Role", "hydrogen-directory"), value: "role" },
              ]);
            }
          })
          .catch(() => {
            setTaxonomies([
              { label: __("Role", "hydrogen-directory"), value: "role" },
            ]);
          });
      }, []);

      // Fetch terms when taxonomy changes
      useEffect(() => {
        if (taxonomy) {
          apiFetch({ path: `/hydrogen-directory/v1/terms/${taxonomy}` })
            .then((data) => {
              if (Array.isArray(data)) {
                setAvailableTerms(data);
              } else {
                setAvailableTerms([]);
              }
            })
            .catch(() => {
              setAvailableTerms([]);
            });
        }
      }, [taxonomy]);

      // Fetch preview when attributes change
      useEffect(() => {
        setIsLoading(true);

        const queryParams = new URLSearchParams({
          taxonomy: taxonomy,
          terms: selectedTerms || "",
          style: style,
          columns: columns.toString(),
          headers: showHeaders ? "1" : "0",
          content: content,
          excerpt_length: excerptLength.toString(),
        });

        apiFetch({
          path: `/hydrogen-directory/v1/preview?${queryParams.toString()}`,
        })
          .then((data) => {
            setPreview(data.html || "");
            setIsLoading(false);
          })
          .catch((error) => {
            console.error("Preview error:", error);
            setPreview(
              "<p>" +
                __(
                  "Unable to load preview. Please check your settings.",
                  "hydrogen-directory"
                ) +
                "</p>"
            );
            setIsLoading(false);
          });
      }, [
        taxonomy,
        selectedTerms,
        style,
        columns,
        showHeaders,
        content,
        excerptLength,
      ]);

      // Helper to toggle a term in the selection
      const toggleTerm = (termSlug) => {
        const currentTerms = selectedTerms
          ? selectedTerms.split(",").filter((t) => t)
          : [];
        const index = currentTerms.indexOf(termSlug);

        if (index === -1) {
          currentTerms.push(termSlug);
        } else {
          currentTerms.splice(index, 1);
        }

        setAttributes({ terms: currentTerms.join(",") });
      };

      // Check if a term is selected
      const isTermSelected = (termSlug) => {
        if (!selectedTerms) return false;
        return selectedTerms.split(",").includes(termSlug);
      };

      // Check if all terms are shown (none selected)
      const showAllTerms = !selectedTerms || selectedTerms === "";

      return wp.element.createElement(
        wp.element.Fragment,
        null,
        wp.element.createElement(
          InspectorControls,
          null,
          // Layout Settings Panel
          wp.element.createElement(
            PanelBody,
            {
              title: __("Layout Settings", "hydrogen-directory"),
              initialOpen: true,
            },
            wp.element.createElement(SelectControl, {
              label: __("Display Style", "hydrogen-directory"),
              value: style,
              options: [
                { label: __("List", "hydrogen-directory"), value: "list" },
                { label: __("Card", "hydrogen-directory"), value: "card" },
                { label: __("Text", "hydrogen-directory"), value: "text" },
              ],
              onChange: (value) => setAttributes({ style: value }),
              help: __(
                "Choose how directory entries are displayed.",
                "hydrogen-directory"
              ),
            }),
            wp.element.createElement(RangeControl, {
              label: __("Columns", "hydrogen-directory"),
              value: columns,
              onChange: (value) => setAttributes({ columns: value }),
              min: 1,
              max: 6,
              help: __(
                "Number of columns to display entries in.",
                "hydrogen-directory"
              ),
            }),
            wp.element.createElement(ToggleControl, {
              label: __("Show Section Headers", "hydrogen-directory"),
              checked: showHeaders,
              onChange: (value) => setAttributes({ showHeaders: value }),
              help: __(
                "Display term names as section headers.",
                "hydrogen-directory"
              ),
            })
          ),
          // Content Settings Panel
          wp.element.createElement(
            PanelBody,
            {
              title: __("Content Settings", "hydrogen-directory"),
              initialOpen: true,
            },
            wp.element.createElement(SelectControl, {
              label: __("Content Display", "hydrogen-directory"),
              value: content,
              options: [
                {
                  label: __("Excerpt", "hydrogen-directory"),
                  value: "excerpt",
                },
                {
                  label: __("Full Content", "hydrogen-directory"),
                  value: "full",
                },
                { label: __("None", "hydrogen-directory"), value: "none" },
              ],
              onChange: (value) => setAttributes({ content: value }),
              help: __(
                "Choose how much content to display for each entry.",
                "hydrogen-directory"
              ),
            }),
            content === "excerpt" &&
              wp.element.createElement(RangeControl, {
                label: __("Excerpt Length", "hydrogen-directory"),
                value: excerptLength,
                onChange: (value) => setAttributes({ excerptLength: value }),
                min: 5,
                max: 100,
                help: __(
                  "Number of words to show in excerpt.",
                  "hydrogen-directory"
                ),
              })
          ),
          // Filter Settings Panel
          wp.element.createElement(
            PanelBody,
            {
              title: __("Filter Settings", "hydrogen-directory"),
              initialOpen: false,
            },
            wp.element.createElement(SelectControl, {
              label: __("Taxonomy", "hydrogen-directory"),
              value: taxonomy,
              options:
                taxonomies.length > 0
                  ? taxonomies
                  : [
                      {
                        label: __("Role", "hydrogen-directory"),
                        value: "role",
                      },
                    ],
              onChange: (value) => {
                setAttributes({ taxonomy: value, terms: "" });
              },
              help: __(
                "Select the taxonomy to group entries by.",
                "hydrogen-directory"
              ),
            }),
            wp.element.createElement(
              BaseControl,
              {
                label: __("Filter by Terms", "hydrogen-directory"),
                help: showAllTerms
                  ? __(
                      "No terms selected - showing all entries.",
                      "hydrogen-directory"
                    )
                  : __(
                      "Only selected terms will be displayed.",
                      "hydrogen-directory"
                    ),
              },
              wp.element.createElement(
                "div",
                { className: "hydir-term-checkboxes" },
                availableTerms.length === 0
                  ? wp.element.createElement(
                      "p",
                      { className: "hydir-no-terms" },
                      __(
                        "No terms found for this taxonomy.",
                        "hydrogen-directory"
                      )
                    )
                  : availableTerms.map((term) =>
                      wp.element.createElement(CheckboxControl, {
                        key: term.slug,
                        label:
                          term.name +
                          (term.count !== undefined
                            ? " (" + term.count + ")"
                            : ""),
                        checked: isTermSelected(term.slug),
                        onChange: () => toggleTerm(term.slug),
                      })
                    )
              )
            ),
            selectedTerms &&
              wp.element.createElement(
                "button",
                {
                  className: "components-button is-secondary is-small",
                  onClick: () => setAttributes({ terms: "" }),
                  style: { marginTop: "8px" },
                },
                __("Clear Selection (Show All)", "hydrogen-directory")
              )
          )
        ),
        // Block content area
        wp.element.createElement(
          "div",
          blockProps,
          isLoading
            ? wp.element.createElement(
                Placeholder,
                {
                  icon: blockIcon,
                  label: __("Hydrogen Directory", "hydrogen-directory"),
                },
                wp.element.createElement(Spinner)
              )
            : wp.element.createElement("div", {
                className: "hydir-block-preview",
                dangerouslySetInnerHTML: { __html: preview },
              })
        )
      );
    },

    save: function () {
      // Dynamic block - rendered on server
      return null;
    },
  });
})(window.wp);
