(function (blocks, element, blockEditor) {
  const el = element.createElement;
  const useBlockProps = blockEditor.useBlockProps;

  blocks.registerBlockType("my-blocks/mokuji-block", {
    title: "目次メニューブロック",
    icon: "list-view",
    category: "common",
    supports: {
      html: false,
    },

    edit: function () {
      const blockProps = useBlockProps();

      return el(
        "div",
        { ...blockProps, className: "mokuji", id: "mokuji" },
        el(
          "div",
          { className: "mokuji__inner" },
          el("p", { className: "mokuji__title" }, "目次"),
          el("ol", { className: "mokuji__list" })
        )
      );
    },

    save: function () {
      const blockProps = useBlockProps.save();
      return el(
        "div",
        { ...blockProps, className: "mokuji", id: "mokuji" },
        el(
          "div",
          { className: "mokuji__inner" },
          el("p", { className: "mokuji__title" }, "目次"),
          el("ol", { className: "mokuji__list" })
        )
      );
    },
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor);
