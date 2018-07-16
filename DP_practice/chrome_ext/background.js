var isCreated = false;
chrome.browserAction.onClicked.addListener(
    function (tab) {
      var scripts = [
        "css_path.js",
        "FileSaver.js",
        "func.js",
        'inject.js'
      ];
      if (!isCreated) {
        scripts.forEach(function(script) {
          chrome.tabs.executeScript(null, { file: script });
        });
        isCreated = true;
      }
});
