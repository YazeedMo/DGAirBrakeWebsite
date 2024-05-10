/* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
const bg = document.querySelector("body");

function openMenu() {
  var x = document.querySelector('.nav-bar ul');
  if (x.style.display === "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}

function hideUl() {
  var x = document.querySelector('.nav-bar ul');
  x.style.display = "none";
}