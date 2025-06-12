document.getElementById("delete-form").addEventListener("submit", function (e) {
  const confirmation = confirm("Are you sure you want to delete this record?");
  if (!confirmation) {
    e.preventDefault();
  }
});

