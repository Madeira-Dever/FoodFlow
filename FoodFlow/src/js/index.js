const waiterButton = document.getElementById("waiter-button");
const chefButton = document.getElementById("chef-button");
const customerButton = document.getElementById("customer-button");

waiterButton.addEventListener("click", () => {
  location.href = "./waiter.html";
});

chefButton.addEventListener("click", () => {
  location.href = "./chef.html";
});

customerButton.addEventListener("click", () => {
  location.href = "./customer.html";
});