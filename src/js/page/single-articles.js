export default async function () {
  function setMokuji() {
    const mokuji = document.querySelector(".mokuji");
    if (mokuji) {
      const mokujis = document.querySelector(".mokuji__list");
      const h2List = document.querySelectorAll("h2");
      if (h2List.length <= 2) {
        mokuji.remove();
        return;
      }

      h2List.forEach((h2Item, index) => {
        h2Item.setAttribute("id", "note" + index);

        const li = document.createElement("li");
        const a = document.createElement("a");
        li.setAttribute("class", "mokuji__item");
        a.setAttribute("class", "mokuji__item-link");
        a.setAttribute("href", "#" + h2Item.id);
        a.textContent = h2Item.textContent;
        a.dataset["link"] = h2Item.id;

        li.appendChild(a);

        mokujis.appendChild(li);
      });

      document.querySelectorAll(".mokuji__item-link").forEach((link) => {
        link.addEventListener("click", (e) => {
          e.preventDefault();
          e.stopPropagation();
        });
      });
    }
  }

  setMokuji();
}
