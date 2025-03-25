document.addEventListener("DOMContentLoaded", function () {
  function TagInput(containerId) {
    const tagContainer = document.getElementById(containerId);
    const input = tagContainer.querySelector(".tag-input");
    const inputValue = tagContainer.querySelector(".input-value");
    let tags = [];

    const isReadOnly = input.hasAttribute("hidden");

    function addTag(event) {
      if (event.key === "Enter" && input.value.trim() !== "") {
        event.preventDefault();
        const tagText = input.value.trim();
        if (!tags.includes(tagText)) {
          tags.push(tagText);
          renderTags();
        }
        input.value = "";
      }
      focusInput();
    }

    function removeTag(index) {
      tags.splice(index, 1);
      renderTags();
    }

    function renderTags() {
      tagContainer.innerHTML = "";
      tags.forEach((tag, index) => {
        // Tạo phần tử tag
        const tagElement = document.createElement("div");
        tagElement.style.height = "22px";
        tagElement.classList.add("tag");

        // Tạo dấu chấm (•)
        const bullet = document.createElement("span");
        bullet.textContent = "•";
        bullet.style.fontSize = "19px";
        bullet.style.marginRight = "5px";
        bullet.style.lineHeight = "7px";

        // Tạo phần văn bản tag
        const tagText = document.createElement("span");
        tagText.textContent = ` ${tag} `;
        if (isReadOnly) {
          tagText.style.marginRight = "5px";
        }

        // Tạo nút xóa
        const removeButton = document.createElement("span");
        removeButton.textContent = "×";
        removeButton.classList.add("btn-remove");
        removeButton.style.cursor = "pointer";
        removeButton.onclick = () => removeTag(index);

        // Thêm các phần tử vào tagElement
        tagElement.appendChild(bullet);
        tagElement.appendChild(tagText);
        if (!isReadOnly) {
          tagElement.appendChild(removeButton);
        }

        // Thêm tagElement vào container
        tagContainer.appendChild(tagElement);
      });
      tagContainer.appendChild(input);
      tagContainer.appendChild(inputValue);
      inputValue.value = tags.join(",");
    }

    function focusInput() {
      input.focus();
    }

    if (inputValue.value.trim() !== "") {
      tags = inputValue.value.split(",").map((tag) => tag.trim());
    }
    renderTags();

    input.addEventListener("keydown", addTag);
    tagContainer.addEventListener("click", focusInput);

    window["removeTag_" + containerId] = removeTag;
  }
  document.querySelectorAll(".tag-container").forEach((tagContainer) => {
    const containerId = tagContainer.id;
    new TagInput(containerId);
  });
});
