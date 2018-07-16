var inspect_activate = false;
var prev_item = null;

var yellow_color = "rgb(253, 255, 71)";
var white_color = "rgb(255, 255, 255)";

function isDescendant(parent, child) {
  var node = child.parentNode;
  while (node != null) {
    if (node == parent) {
      return true;
    }
    node = node.parentNode;
  }
  return false;
}

function adjust_color(elem) {
  if (elem.style.backgroundColor == undefined)
    return;
  if (elem.style.backgroundColor != yellow_color)
    elem.style.backgroundColor = yellow_color;
  else
    elem.style.backgroundColor = white_color;
}

function highlight(e) {
  if (!inspect_activate)
    return;
  adjust(e.target);
}

function mmove(e) {
  if (!inspect_activate)
    return;
  if (prev_item == null) {
    prev_item = e.target;
  }
  else {
    let cur_item = e.target;
    if (cur_item != prev_item) {
      adjust_color(prev_item);
      adjust_color(cur_item);
      prev_item = cur_item;
    }
  }
}

function mapb(f) {
  document.querySelectorAll('body *').forEach(function(node) {
    f(node);
  });
}

//document.body.addEventListener('click', highlight, false);
//document.body.addEventListener('mousemove', mmove, false);
//mapb(e => e.addEventListener('mousemove', mmove, false));
