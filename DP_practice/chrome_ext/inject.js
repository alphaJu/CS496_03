var records = [];
var record_activate = false;
var rec_button_id = "button_C773FB8472D65E09634BDEFFA080BF3602D1F68C";
var imp_file_id = "button_C773FB8472D65E09634BDEFFA080BF3602D1F68D";
var imp_button_id = "button_C773FB8472D65E09634BDEFFA080BF3602D1F68E";

function recordFunc(e) {
  if (e.target.id == rec_button_id)
    return;
  if (!record_activate)
    return;
  records.push({eventType:e.type, item:e.target});
  console.log(e);
  // alert("Recorded! : " + e.type);
}

function rcButtonListener(e) {
  var rcButton = document.getElementById(rec_button_id);
  if (record_activate) {
    record_activate = false;
    rcButton.innerText = "Start recording";

    for (i in records) {
      record = records[i];
      record["css_path"] = UTILS.cssPath(record["item"]);
      delete record.item;
    }

    let result = {"url" : window.location.href, "records" : records};
    let result_string = JSON.stringify(result);
    alert(result_string); // -> make json file with result_string.
    let bb = self.Blob;
    saveAs(new bb([result_string], {type: "text/plain"}), "records1"); // result_string (x) [result_string] (o)
    records = [];

  } else {
    records = [];
    rcButton.innerText = "Stop recording";
    record_activate = true;
  }
}

function impButtonListener(e) {
  var impFile = document.getElementById(imp_file_id);
  var f = impFile.files[0]
}

var record_button = document.createElement("button");
record_button.setAttribute("type", "button");
record_button.setAttribute("id", rec_button_id);
record_button.innerText = "Start recording";
record_button.addEventListener('click', rcButtonListener, false);
document.body.insertBefore(record_button, document.body.firstChild);

var import_file = document.createElement("INPUT");
import_file.setAttribute("type", "file");
import_file.setAttribute("id", imp_file_id);
import_file.innerText = "File to import";
document.body.insertBefore(import_file, document.body.firstChild.nextSibling);

var import_button = document.createElement("button");
import_button.setAttribute("type", "button");
import_button.setAttribute("id", imp_button_id);
import_button.innerText = "IMPORT";
import_button.addEventListener('click', impButtonListener, false);
document.body.insertBefore(import_button, document.body.firstChild.nextSibling.nextSibling);

event_list = ['click', 'scroll'];
for (i in event_list) {
  let eType = event_list[i];
  //window.addEventListener('click', recordFunc, false); // e.type = "click"

  document.querySelectorAll('body *').forEach(function(node) {
    node.addEventListener(eType, recordFunc, false);
  });

  //window.addEventListener(eType, recordFunc, false);
}
