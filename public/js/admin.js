// Click Menu -> show submenu (Sidebar)
function clickMenu () {
  var x = document.getElementById('treeview-menu');
  if (x.style.display === "block") {
    x.style.display = "none";
    document.getElementById("sidebar-down").className = "fa fa-angle-down";
  } else {
    x.style.display = "block";
    document.getElementById("sidebar-down").className = "fa fa-angle-up";
  }
}

function cutObjURL(obj, url) {
  obj = '&' + obj + '=';
  var arr = {};
  // Object is found
  if (url.indexOf(obj) > 0) {
    // Get value of OBJ in url (Lấy giá trị của đối tượng trong url - phần sau dấu =)
    arr.obj = url.slice(url.indexOf(obj) + obj.length);
    // Get new url after cut (Cut from the begin to the location found)
    arr.url = url.slice(0, url.indexOf(obj));
  } else {
    arr.obj = '';
    arr.url = url;
  }
  return arr;
}

function createObjURL(key, value) {
  var obj = {};
  if (value.trim().length == 0) {
    obj.url = '';
  } else {
    obj.url = '&' + key + '=' + value;
  }
  return obj;
}

// Change the number element of page ($limit)
function limitChanged(obj) {
  var currentURL = window.location.toString();

  page = new cutObjURL('page', currentURL);
  limit = new cutObjURL('limit', page.url);

  var url = limit.url + '&limit=' + obj.value;
  window.location.href = url;
}

// Sort by database
function sortDB(obj) {
  var currentURL = window.location.toString();

  page = new cutObjURL('page', currentURL);
  limit = new cutObjURL('limit', page.url);
  arrange = new cutObjURL('arrange', limit.url);
  row = new cutObjURL('row', arrange.url);

  limit = new createObjURL('limit', limit.obj);
  page = new createObjURL('page', page.obj);

  var url1 = row.url + '&row=' + obj.trim();
  arrange = arrange.obj.trim();

  var url;

  if (arrange.trim().length == 0) { 
    url = url1 + '&arrange=desc' + limit.url + page.url;
  } else {
    if (arrange == 'desc') {
      arrange = 'asc';
    } else if (arrange == 'asc') {
      arrange = 'desc';
    }
    url = url1 + '&arrange=' + arrange + limit.url + page.url;
  }
  window.location.href = url;
}

// Get name image
function getImage(obj) {
  temp = obj.split('\\');
  obj = temp[temp.length - 1]; 
  document.getElementById('nameAvatar').innerHTML = obj;
} 
