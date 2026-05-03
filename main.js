function loginUser(e){
  e.preventDefault();
  const email=document.getElementById('email').value;
  alert("Welcome, "+email+"! (Backend will be added later)");
  window.location.href='profile.html';
}

window.addEventListener("load", function () {

    const params = new URLSearchParams(window.location.search);
    const search = params.get("search");

    if (search) {
        let value = search.toLowerCase();

        let targetId = "";

        if (value.includes("cake")) targetId = "cakes";
        else if (value.includes("cupcake")) targetId = "cupcakes";
        else if (value.includes("cookie")) targetId = "cookies";
        else if (value.includes("waffle")) targetId = "waffles";
        else if (value.includes("brownie")) targetId = "brownies";
        else if (value.includes("chocolate")) targetId = "chocolate";
        else if (value.includes("croissant")) targetId = "croissant";
        else if (value.includes("cheesecake")) targetId = "cheesecake";

        if (targetId && document.getElementById(targetId)) {
            setTimeout(() => {
                document.getElementById(targetId).scrollIntoView({
                    behavior: "smooth"
                });
            }, 300); // delay important hai
        }
    }

});
