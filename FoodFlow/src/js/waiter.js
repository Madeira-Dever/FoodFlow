import { showToast, request } from "./functions";
showToast("Welcome");

const orderList = document.querySelector(".order-list");

const getProduct = async () => {
  const result = await request("getOrder");
  orderList.innerHTML = "";
  result.forEach((item) => createCard(item));
};

const createCard = (item) => {
  const card = document.createElement("li");
  card.className = "order-card";
  card.innerHTML = `
    <article class="item">
      <header class="item-header">
        <span class="item-id">${item.id}</span>
        <span class="item-status">Ready for delivery</span>
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
        <button type="button" class="item-button">Delivery this order</button>
      </footer>
    </article>
  `;

  orderList.append(card);

  const itemButton = card.querySelector(".item-button");
  itemButton.addEventListener("click", () => prepare(item, card));
};

const prepare = async (order, card) => {
  try {
    await request("prepareOrder", "POST", order);
    card.remove("li");
    showToast("Order Sent", "success", 1500);
  } catch (err) {
    showToast("Error in prepare order", "error");
    console.error(err);
  }
};

getProduct();