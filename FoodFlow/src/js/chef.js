import { showToast, request } from "./functions";

// ==========================
// GET PRODUCT FROM DATABASE
// ==========================
const getProduct = async () => {
  try {
    const result = await request("receiveOrder");
    result.forEach((item) => createCard(item));
    showToast("Order received", "success");
  } catch (err) {
    showToast("Failed do recived order", "error");
    console.error(err.message);
  }
};

// ==========================
// CREATE CARD PRODUCT
// ==========================
const createCard = (item) => {
  const card = document.createElement("li");
  card.className = "order-card";
  card.innerHTML = `
    <article class="item">
      <header class="item-header">
        <span class="item-id">${item.id}</span>
        <span class="item-status">In preparation</span>
      </header>

      <div class="item-info">
        <h3 class="item-name">${item.name}</h3>
        <p class="item-flavor">${item.flavor}</p>
        <p class="item-description">
          ${item.description}
        </p>
      </div>

      <div class="recipient">
        <span class="size">
          Size:&#x20;
          <strong> ${item.size} </strong>
        </span>

        <span class="price">
          Price:
          <strong> U$ ${item.price} </strong>
        </span>
      </div>

      <footer class="item-footer">
        <button type="button" class="item-button">Prepare this order</button>
      </footer>
    </article>
  `;

  const options = document.querySelector(".options");
  options.append(card);

  const itemButton = card.querySelector(".item-button");
  itemButton.addEventListener("click", () => prepare(item, card));
};

// ==========================
// PREPARE PRODUCT TO WAITER
// ==========================
const prepare = async (order, card) => {
  try {
    await request("prepareOrder", "POST", order);
    card.remove("li");
    showToast("Order ready", "success", 1500);
  } catch (err) {
    showToast("Error in prepare order", "error");
    console.error(err);
  }
};

getProduct();