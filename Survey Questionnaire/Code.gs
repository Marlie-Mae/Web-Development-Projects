// Apps Script

function doPost(e) {
  var ss = SpreadsheetApp.openById("1woM44iptRuP9nJANfHj8GWY_4AjOLkm2xhjRrpPUxm0");
  var sheet = ss.getSheetByName("RawData");

  var id = e.parameter.id;
  var tab = e.parameter.tab;
  var answers = e.parameter.answers;
  var timestamp = e.parameter.timestamp;

  // Get all rows
  var data = sheet.getDataRange().getValues();

  // Search for existing ID
  for (var i = 1; i < data.length; i++) {
    if (data[i][0] == id) {
      // Found → overwrite row i+1 (because index is zero-based)
      sheet.getRange(i + 1, 1, 1, 4).setValues([
        [id, tab, answers, timestamp]
      ]);
      
      return ContentService
        .createTextOutput("Updated existing row")
        .setMimeType(ContentService.MimeType.TEXT);
    }
  }

  // If no match → append new
  sheet.appendRow([id, tab, answers, timestamp]);

  return ContentService
    .createTextOutput("Added new row")
    .setMimeType(ContentService.MimeType.TEXT);
}
