{
  function sortTable(columnIndex) {
    var table = document.getElementById("inventory");
    var tbody = table.querySelector("tbody");
    var rows = Array.from(tbody.rows);

    rows.sort(function (a, b) {
      var cellA = a.cells[columnIndex].innerText.toLowerCase();
      var cellB = b.cells[columnIndex].innerText.toLowerCase();

      return cellA.localeCompare(cellB);
    });

    // Create a new table body to hold the sorted rows
    var newTbody = document.createElement("tbody");
    rows.forEach(function (row) {
      newTbody.appendChild(row);
    });

    // Replace the existing table body with the sorted one
    table.replaceChild(newTbody, tbody);
  }

  var inventoryData = [
    { product: "Product 1", quantity: 10, price: "$20" },
    { product: "Product 2", quantity: 5, price: "$15" }
    // Add more inventory data as needed
  ];
  
  // Generate the table rows dynamically
  function generateTableRows() {
    var tbody = document.getElementById("inventoryBody");
  
    // Clear the existing table body
    tbody.innerHTML = "";
  
    // Generate a table row for each item in the inventory
    inventoryData.forEach(function(item) {
      var row = document.createElement("tr");
  
      // Create table cells for each item property
      var productCell = document.createElement("td");
      productCell.textContent = item.product;
      row.appendChild(productCell);
  
      var quantityCell = document.createElement("td");
      quantityCell.textContent = item.quantity;
      row.appendChild(quantityCell);
  
      var priceCell = document.createElement("td");
      priceCell.textContent = item.price;
      row.appendChild(priceCell);
  
      var actionCell = document.createElement("td");
      var deleteButton = document.createElement("button");
      deleteButton.classList.add("btn", "btn-danger", "btn-sm");
      deleteButton.textContent = "Delete";
      deleteButton.addEventListener("click", function() {
        deleteItem(row);
      });
      actionCell.appendChild(deleteButton);
      row.appendChild(actionCell);
  
      // Append the row to the table body
      tbody.appendChild(row);
    });
  }
  
  // Call the function to generate table rows
  generateTableRows();
  
  // Delete an item from the table
  function deleteItem(row) {
    row.remove();
  }
}
