
  "use strict";
function _typeof(obj) {
  "@babel/helpers - typeof";
  return (
    (_typeof =
      "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
        ? function (obj) {
            return typeof obj;
          }
        : function (obj) {
            return obj &&
              "function" == typeof Symbol &&
              obj.constructor === Symbol &&
              obj !== Symbol.prototype
              ? "symbol"
              : typeof obj;
          }),
    _typeof(obj)
  );
}
function ownKeys(object, enumerableOnly) {
  var keys = Object.keys(object);
  if (Object.getOwnPropertySymbols) {
    var symbols = Object.getOwnPropertySymbols(object);
    enumerableOnly &&
      (symbols = symbols.filter(function (sym) {
        return Object.getOwnPropertyDescriptor(object, sym).enumerable;
      })),
      keys.push.apply(keys, symbols);
  }
  return keys;
}
function _objectSpread(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = null != arguments[i] ? arguments[i] : {};
    i % 2
      ? ownKeys(Object(source), !0).forEach(function (key) {
          _defineProperty(target, key, source[key]);
        })
      : Object.getOwnPropertyDescriptors
      ? Object.defineProperties(
          target,
          Object.getOwnPropertyDescriptors(source)
        )
      : ownKeys(Object(source)).forEach(function (key) {
          Object.defineProperty(
            target,
            key,
            Object.getOwnPropertyDescriptor(source, key)
          );
        });
  }
  return target;
}
function _defineProperty(obj, key, value) {
  key = _toPropertyKey(key);
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true,
    });
  } else {
    obj[key] = value;
  }
  return obj;
}
function _toPropertyKey(arg) {
  var key = _toPrimitive(arg, "string");
  return _typeof(key) === "symbol" ? key : String(key);
}
function _toPrimitive(input, hint) {
  if (_typeof(input) !== "object" || input === null) return input;
  var prim = input[Symbol.toPrimitive];
  if (prim !== undefined) {
    var res = prim.call(input, hint || "default");
    if (_typeof(res) !== "object") return res;
    throw new TypeError("@@toPrimitive must return a primitive value.");
  }
  return (hint === "string" ? String : Number)(input);
}
$(function () {
  var isDarkDefault = localStorage.getItem("theme-variant") == "dark";
  var themeVariantDefault = isDarkDefault ? "dark" : "light";
  var colors = { white: "#fff", black: "#424242" };
  var themeOptions = {
    light: { theme: { mode: "light", palette: "palette1" } },
    dark: { theme: { mode: "dark", palette: "palette1" } },
  };

  var chart4 = new ApexCharts(
    document.querySelector("#apexchart-4"),
    _objectSpread(
      _objectSpread({}, themeOptions[themeVariantDefault]),
      {},
      {
        series: [
          { data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380] },
        ],
        chart: { type: "bar", height: 350, background: "transparent" },
        plotOptions: { bar: { horizontal: true } },
        dataLabels: { enabled: false },
        xaxis: {
          categories: [
            "South Korea",
            "Canada",
            "United Kingdom",
            "Netherlands",
            "Italy",
            "France",
            "Japan",
            "United States",
            "China",
            "Germany",
          ],
        },
      }
    )
  );
  chart4.render();
  $("#theme-toggle").on("click", function () {
    var isDark = $("html").attr("data-theme") == "dark";
    var themeVariant = isDark ? "dark" : "light";
    chart1.updateOptions(
      _objectSpread(
        _objectSpread({}, themeOptions[themeVariant]),
        {},
        { markers: { strokeColors: isDark ? colors.black : colors.white } }
      )
    );
    chart2.updateOptions(
      _objectSpread(
        _objectSpread({}, themeOptions[themeVariant]),
        {},
        { markers: { strokeColors: isDark ? colors.black : colors.white } }
      )
    );
    chart3.updateOptions(themeOptions[themeVariant]);
    chart4.updateOptions(themeOptions[themeVariant]);
    chart5.updateOptions(
      _objectSpread(
        _objectSpread({}, themeOptions[themeVariant]),
        {},
        { markers: { strokeColors: isDark ? colors.black : colors.white } }
      )
    );
    chart6.updateOptions(themeOptions[themeVariant]);
    chart7.updateOptions(themeOptions[themeVariant]);
    chart8.updateOptions(themeOptions[themeVariant]);
    chart9.updateOptions(
      _objectSpread(
        _objectSpread({}, themeOptions[themeVariant]),
        {},
        { markers: { strokeColors: isDark ? colors.black : colors.white } }
      )
    );
    chart10.updateOptions(
      _objectSpread(
        _objectSpread({}, themeOptions[themeVariant]),
        {},
        { markers: { strokeColors: isDark ? colors.black : colors.white } }
      )
    );
  });
});
