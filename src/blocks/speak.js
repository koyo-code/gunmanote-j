(function (blocks, element, blockEditor, components) {
  const el = element.createElement;
  const useBlockProps = blockEditor.useBlockProps;
  const RichText = blockEditor.RichText;
  const MediaUpload = blockEditor.MediaUpload;
  const Button = components.Button;

  blocks.registerBlockType("my-blocks/speak-block", {
    title: "スピークブロック",
    icon: "format-image",
    category: "common",
    attributes: {
      text: { type: "string", source: "html", selector: ".speak__text" },
      imageUrl: {
        type: "string",
        source: "attribute",
        selector: ".speak__image",
        attribute: "src",
      },
    },

    edit: function (props) {
      const blockProps = useBlockProps({
        className: "speak",
        style: {
          padding: "15px",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          gap: "15px",
          border: "1px solid #ccc",
          background: "#f9f9f9",
        },
      });

      return el(
        "div",
        blockProps,
        el(RichText, {
          tagName: "p",
          className: "speak__text",
          value: props.attributes.text,
          onChange: function (newText) {
            props.setAttributes({ text: newText });
          },
          placeholder: "ここにテキストを入力",
        }),
        el(MediaUpload, {
          onSelect: function (media) {
            props.setAttributes({ imageUrl: media.url });
          },
          allowedTypes: ["image"],
          render: function (obj) {
            return el(
              "div",
              {},
              props.attributes.imageUrl &&
                el("img", {
                  src: props.attributes.imageUrl,
                  className: "speak__image",
                  style: { maxWidth: "200px", display: "block" },
                }),
              el(
                Button,
                { onClick: obj.open, className: "button button-primary" },
                "画像を選択"
              )
            );
          },
        })
      );
    },

    save: function (props) {
      const blockProps = useBlockProps.save({ className: "speak" });

      return el(
        "div",
        blockProps,
        el(RichText.Content, {
          tagName: "p",
          className: "speak__text",
          value: props.attributes.text,
        }),
        props.attributes.imageUrl &&
          el("img", {
            src: props.attributes.imageUrl,
            className: "speak__image",
            alt: "",
          })
      );
    },
  });
})(
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components
);
