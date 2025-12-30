export default async function loadPageFile() {
  const pageEl = document.querySelector("[data-page]");
  const pageFile = await import(`./page/${pageEl.dataset.page}.js`)
    .then(({ default: init }) => {
      return init();
    })
    .catch((e) => {});
  return pageFile;
}
