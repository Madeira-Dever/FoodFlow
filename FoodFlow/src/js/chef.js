import { showToast, request } from "./functions";

const options = document.getElementById("options");

// =========================================================
// GET ORDER
// =========================================================
const getOrder = async () => {
  try {
    const data = await request("getOrder");
    showToast(data.message);
    data.order.forEach((product) => createCard(product));
  } catch (err) {
    console.error(err.message);
    showToast("Ocorreu algum erro", "error");
  }
};

// =========================================================
// CREATE PROCUCT CARD
// =========================================================
const createCard = (product) => {
  const li = document.createElement("li");
  li.className = "order-card";
  li.innerHTML = `
    <article class="item">
      <header class="item-header">
        <span class="item-id">Cliente - ${product.id_request}</span>
        <span class="item-status">${product.status}</span>
      </header>

      <div class="item-info">
        <h3 class="item-name">${product.name}</h3>
        <p class="item-flavor">${product.flavor}</p>
        <p class="item-description">${product.description}</p>
      </div>

      <div class="recipient">
        <span class="size">
          Size:&#x20;
          <strong>${product.size}</strong>
        </span>

        <span class="price">
          Price:
          <strong>U$ ${product.price}</strong>
        </span>
      </div>

      <footer class="item-footer">
        <button type="button" class="item-button">Preparar pedido</button>
      </footer>
    </article>
  `;

  options.append(li);

  const itemButton = li.querySelector(".item-button");
  itemButton.addEventListener("click", () => prepare(product, li));
};

// =========================================================
// PREPARE PRODUCT TO WAITER
// =========================================================
const prepare = async (item, card) => {
  try {
    await request("prepareOrder", "POST", { id: item.id_product });
    card.remove();
    showToast("Produto Pronto", "success");

    if (options.children.length < 1) {
      showToast("Todos os produtos estão prontos");
      setTimeout(() => {
        location.href = "../../src/pages/selection.html";
      }, 3000);
    }
  } catch (err) {
    console.error(err.message);
    showToast(err.message, "error");
  }
};

getOrder();