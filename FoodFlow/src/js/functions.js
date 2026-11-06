export const showToast = (message, type = "info", duration = 3000) => {
  let container = document.querySelector(".toastContainer");

  if (!container) {
    container = document.createElement("div");
    container.className = "toastContainer";
    document.body.appendChild(container);
  }

  const icons = {
    success: "✓",
    error: "!",
    warning: "!",
    info: "i",
  };

  const toast = document.createElement("div");
  toast.className = `toast toast-${type}`;

  toast.innerHTML = `
    <div class="toastIcon">${icons[type] || icons.info}</div>

    <div class="toastContent">
      <span class="toastMessage"></span>
    </div>

    <button 
      class="toastClose" 
      type="button" 
      aria-label="Fechar"
    >X</button>

    <div
      class="toastProgress"
      style="--toast-duration: ${duration}ms"
    ></div>
  `;

  toast.querySelector(".toastMessage").textContent = message;
  container.appendChild(toast);

  let timeout;
  function removeToast() {
    clearTimeout(timeout);

    toast.classList.add("hide");
    toast.addEventListener(
      "animationend",
      () => {
        toast.remove();

        if (!container.children.length) {
          container.remove();
        }
      },
      { once: true },
    );
  }

  toast.querySelector(".toastClose").addEventListener("click", removeToast);
  timeout = setTimeout(removeToast, duration);
};

export const request = async (name, method = "GET", body = null, path = "../php/") => {
  const options = {
    method,
    headers: { "Content-Type": "application/json; charset=utf8" },
  };

  if (body !== null) {
    options.body = JSON.stringify(body);
  }

  // const response = await fetch(`../../FoodFlow/src/php/${name}.php`, options);
  const response = await fetch(`${path}${name}.php`, options);
  const result = await response.json();

  if (!response.ok) {
    throw new Error(result.message || "Requisição falha");
  }

  return result;
};