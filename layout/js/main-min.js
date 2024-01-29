let toggleMenu = document.querySelector(".page .toggle-menu"),
  links = document.querySelector(".page  .links-area"),
  showMore = document.querySelectorAll(".page .page-body .show-more"),
  fullInfo = document.querySelectorAll(".page .page-body .full-info"),
  productSelect = document.querySelector(".productSelect"),
  priceInput = document.querySelector(".price"),
  priceT = document.querySelector(".price-t"),
  quant = document.querySelector(".quant"),
  priceP = document.querySelectorAll(".price_p"),
  info = document.querySelectorAll(".home-page .info li"),
  tableType = document.querySelectorAll(".home-page .table-type"),
  nbPieces = document.querySelector(".home-page .nb_pieces"),
  check = document.querySelector(".home-page .check"),
  ctx = document.getElementById("myChart"),
  monthInput = document.querySelector(".input_date");
(toggleMenu.onclick = function () {
  links.classList.toggle("open");
}),
  document.addEventListener("click", (e) => {
    const t = e.target.classList;
    if (t.contains("show-more")) {
      const o = e.target.parentElement.parentElement.dataset.prod,
        n = document.querySelector("." + o);
      showMore.forEach((e) => {
        o !== e.parentElement.parentElement.dataset.prod &&
          (e.classList.add("fa-eye-slash"), e.classList.remove("fa-eye"));
      }),
        t.toggle("fa-eye-slash"),
        t.toggle("fa-eye"),
        fullInfo.forEach((e) => {
          o !== e.classList.item(2) && (e.style.display = "none");
        });
      const l = window.getComputedStyle(n).display;
      n.style.display = "none" === l ? "block" : "none";
    }
  }),
  info.forEach((element) => {
    element.addEventListener("click", (e) => {
      fullInfo.forEach((element) => {
        element.style.display = "none";
      });

      showMore.forEach((element) => {
        if (element.classList.contains("fa-eye")) {
          element.classList.remove("fa-eye");
        }
        element.classList.add("fa-eye-slash");
      });

      info.forEach((element) => {
        element.classList.remove("active");
      });

      e.target.classList.add("active");
      tableType.forEach((element) => {
        element.classList.remove("active");
      });

      document
        .querySelector("." + e.target.dataset.type)
        .classList.add("active");
    });
  });

// /chars

function profitsCurve(ctx, month) {
  dataArray = [];
  labelsArray = [];

  document
    .querySelectorAll(".page-body .profits .info-table tbody tr ")
    .forEach((element) => {
    
      dateM = element.querySelector(".date").textContent.substring(0, 7);

      if (dateM == month) {
        let cleanedValue = element
          .querySelector(".price_p")
          .textContent.replace(/[,\sDZD]/g, "");

        dataArray.unshift(parseFloat(cleanedValue));
        labelsArray.unshift(
          element.querySelector(".date").textContent.substring(8)
        );
        ans = element.querySelector(".date").textContent.substring(0, 4);
      }
    });

  indexMonth = parseFloat(month.substring(5)) - 1;
  months = [
    "  جانفي " + ans,
    " فيفري " + ans,
    " مارس " + ans,
    " افريل " + ans,
    " ماي " + ans,
    " جوان " + ans,
    " جيولية " + ans,
    " اوت " + ans,
    " سبتمبر " + ans,
    " اكتوبر " + ans,
    " نوفمبر " + ans,
    " ديسمبر " + ans,
  ];
  var chart = new Chart(ctx, {
    // النوع
    type: "line",

    // البيانات
    data: {
      labels: labelsArray,
      datasets: [
        {
          label: "ارباحي",

          backgroundColor: "#e74c3ca6",
          borderColor: "#c0392b",

          data: dataArray,
        },
      ],
    },

    // خيارات التكوين
    options: {
      layout: {
        padding: 10,
        backgroundColor: "rgba(255, 255, 255, 0.8)", // لون خلفية ال layout
      },
      legend: {
        position: "bottom",
        labels: {
          fontColor: "white", // لون التسمية
        },
      },
      title: {
        display: true,
        text: " ارباحي لشهر" + months[indexMonth],
        fontColor: "white",
        fontSize: 18,
      },
      scales: {
        yAxes: [
          {
            scaleLabel: {
              display: true,
              labelString: "الاموال",
              fontColor: "white",
              fontSize: 18,
            },
            ticks: {
              fontColor: "white",
              // لون الأرقام على المحور
            },
          },
        ],
        xAxes: [
          {
            scaleLabel: {
              display: true,
              labelString: " الزمن",
              fontColor: "white",
              fontSize: 18,
            },
            ticks: {
              fontColor: "white", // لون الأرقام على المحور
            },
          },
        ],
      },
    },
  });
}

if (ctx !== null) {
  ctx = ctx.getContext("2d");
  profitsCurve(ctx, monthInput.value);
  monthInput.addEventListener("change", function (e) {
    profitsCurve(ctx, e.target.value);
  });
}

document.addEventListener("change", function () {
  if (productSelect !== null) {
    var $id = productSelect.value;
    $id = $id.split(",");
    fetch("api.php")
      .then((response) => response.json())
      .then((data) => {
        data["products"].forEach((element) => {
          if ($id[0] == element["id"]) {
            if (productSelect.classList.contains("productPurchases")) {
              priceInput.value = element["price"];
            } else {
              priceInput.value = element["price_selling"];
            }
          }
        });
        data["my_purchases"].forEach((element) => {
          if ($id[1] == element["id_purchases"]) {
            if (productSelect.classList.contains("productSales")) {
              nbPieces.placeholder =
                element["nb_pieces"] + " عدد القطع لا يتجاوز";
              nbPieces.max = element["nb_pieces"];
            }
          }
        });
      })
      .catch((error) => console.error("Error:", error));
  }
});

document.addEventListener("keyup", function () {
  if (quant !== null) {
    priceT.textContent = add_commas_and_underscore(
      priceInput.value * quant.value
    );
  }
});

function add_commas_and_underscore(num) {
  if (num !== "") {
    let result = num.toLocaleString("en-US", {
      style: "currency",
      currency: "DZD",
    });
    return result;
  } else {
    return num;
  }
}

priceP.forEach((element) => {
  var price = parseFloat(element.textContent);

  element.textContent = add_commas_and_underscore(price);
});

document.addEventListener("change", function (e) {
  if (e.target.classList.contains("check")) {
    if (e.target.checked) {
      e.target.value = 1;
    } else {
      e.target.value = 0;
    }
  }
});
