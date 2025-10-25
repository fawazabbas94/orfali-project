// Function to scale path data by a given factor
function scalePathData(pathData, scaleFactor) {
  return pathData.replace(
    /([MLHVCSQTZ])([^MLHVCSQTZ]*)/gi,
    function (_, command, coords) {
      if (coords.trim() === "") return command;
      const scaledCoords = coords
        .split(/[\s,]+/)
        .map(function (coord) {
          const number = parseFloat(coord);
          return isNaN(number) ? coord : (number * scaleFactor).toString();
        })
        .join(" ");
      return command + scaledCoords;
    }
  );
}
var iscountyselected = false;
var previouscountyselected = "blank";
var start = true;
var past = null;
var content_dir = "details";
$(function () {
  var r = Raphael("map"),
    attributes = {
      fill: "#666",
      stroke: "#fff",
      "stroke-width": 0.5,
      "stroke-linejoin": "round",
    },
    arr = new Array();
  for (var county in paths) {
    var scaledPathData = scalePathData(paths[county].path, 1.4);
    paths[county].path = scaledPathData;
    var obj = r.path(paths[county].path);
    obj.attr(attributes);
    arr[obj.id] = county;
    if (arr[obj.id] != "blank") {
      obj.data("selected", "notSelected");
      obj.node.id = arr[obj.id];
      obj.attr(attributes).attr({ title: paths[arr[obj.id]].name });
      obj.hover(
        function () {
          $("#coatOfArms").addClass(arr[this.id] + "large sprite-largecrests");
          $("#countyInfo").text(paths[arr[this.id]].name);
          $("#searchResults").stop(true, true);
          $("#D-" + paths[arr[this.id]].slug).css("display", "block");
        },
        function () {
          $("#coatOfArms").removeClass();
          if (paths[arr[this.id]].value == "notSelected") {
            $("." + paths[arr[this.id]].name).slideUp("slow", function () {
              $(this).remove();
            });
          }
          $("#D-" + paths[arr[this.id]].slug).css("display", "none");
        }
      );
      $("svg a").qtip({
        content: { attr: "title" },
        show: "mouseover",
        hide: "mouseout",
        position: { target: "leave" },
        style: { classes: "ui-tooltip-tipsy ui-tooltip-shadow", tip: false },
      });
      obj.click(function () {
        if (paths[arr[this.id]].value == "notSelected") {
          this.animate({ fill: "#000" }, 200);
          if (previouscountyselected && paths[previouscountyselected]) {
            paths[previouscountyselected].value = "notSelected";
          }
          paths[arr[this.id]].value = "isSelected";
          previouscountyselected = arr[this.id];
          $("<div/>", {
            title: arr[this.id],
            class: arr[this.id] + "small sprite-smallcrests",
          })
            .appendTo("#selectedCounties")
            .qtip(countyCrest);
          $("#countymenu").val(paths[arr[this.id]].county);
          if (!start && past != this) {
            past.animate({ fill: "#666" }, 200);
          }
          past = this;
          start = false;
        } else if (paths[arr[this.id]].value == "isSelected") {
          this.animate({ fill: "#1c75bc" }, 200);
          paths[arr[this.id]].value = "notSelected";
          $("." + arr[this.id] + "small").remove();
        }
        var districtSlug = paths[arr[this.id]].slug;
        window.location.href = "/listings/?_district=" + districtSlug;
      });
      var countyCrest = {
        content: { attr: "title" },
        position: { target: "mouse" },
        style: { classes: "ui-tooltip-tipsy ui-tooltip-shadow", tip: true },
      };
      function hoverin(e) {
        if (paths[arr[this.id]].value == "notSelected")
          this.animate({ fill: "#1c75bc" }, 50);
      }
      function hoverout(e) {
        if (paths[arr[this.id]].value == "notSelected")
          this.animate({ fill: "#666" }, 300);
      }
      obj.mouseout(hoverout);
      obj.mouseover(hoverin);
      $("#countyInfo").hide();
      $("#spinner").hide();
    }
  }
});
