document.addEventListener("DOMContentLoaded", function () {
  const editLink = document.querySelectorAll(".row-actions .edit a");
  const trashLink = document.querySelectorAll(".row-actions .trash a");
  const viewLink = document.querySelectorAll(".row-actions .view a");
  const quickEditLink = document.querySelectorAll(
    ".row-actions .inline button"
  );
  const duplicateLink = document.querySelectorAll(".row-actions .duplicate a");
  const markAvailableLink = document.querySelectorAll(
    ".column-listing_status .available,.column-project_status .available"
  );
  const markNotAvailableLink = document.querySelectorAll(
    ".column-listing_status .sold_out,.column-project_status .sold_out"
  );
  const copyLink = document.querySelectorAll(".copy-listing-link");
  const editVcLink = document.querySelectorAll(".row-actions .edit_vc a");
  const formDuplicateLink = document.querySelectorAll(".row-actions .copy a");
  const acfduplicateLink = document.querySelectorAll(
    ".row-actions .acfduplicate a"
  );
  const acfdeactivateLink = document.querySelectorAll(
    ".row-actions .acfdeactivate a"
  );
  const taxDeleteLink = document.querySelectorAll(".row-actions .delete a");

  editLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-edit");
    link.setAttribute("title", "Edit");
  });

  trashLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-trash");
    link.setAttribute("title", "Move to trash");
  });

  taxDeleteLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-trash");
    link.setAttribute("title", "Delete");
  });

  viewLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-visibility");
    link.setAttribute("title", "View");
  });

  quickEditLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-edit-page");
    link.setAttribute("title", "Quick edit");
  });

  duplicateLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-admin-page");
  });

  formDuplicateLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-admin-page");
    link.setAttribute("title", "Duplicate");
  });

  acfduplicateLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-admin-page");
    link.setAttribute("title", "Duplicate");
  });

  acfdeactivateLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-remove");
    link.setAttribute("title", "Deactivate");
  });

  markAvailableLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-controls-pause");
  });

  markNotAvailableLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-controls-play");
  });

  editVcLink.forEach(function (link) {
    link.innerHTML = "";
    const img = document.createElement("img");
    img.src = "/wp-content/themes/woodmart-child/icons/admin/wpb-logo.svg";
    img.style.width = "16px";
    img.style.height = "16px";
    img.style.verticalAlign = "middle";
    link.appendChild(img);
    link.setAttribute("title", "Edit with Visual Composer");
  });

  copyLink.forEach(function (link) {
    link.innerHTML = "";
    link.classList.add("dashicons", "dashicons-admin-links");
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const postId = link.getAttribute("data-post-id");
      const tempInput = document.createElement("textarea");
      tempInput.value = window.location.origin + "/?p=" + postId;
      document.body.appendChild(tempInput);
      tempInput.select();
      document.execCommand("copy");
      document.body.removeChild(tempInput);
      alert("Listing link copied to clipboard.");
    });
  });
});