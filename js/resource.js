function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

function add_selected_item() {

    var x = document.getElementById("KStargets");
    var option = document.createElement("option");
    option.text = data.instance.get_node(data.selected[0]).text;
    x.add(option);

    return true;
}

/***********************************************************************************************************************/
function remove_selected_item(l1) {
    do {
        flag_delete = false;
        for (var i = 0; i < l1.options.length; i++) {
            if (l1.options[i].selected == true) {
                l1.options[i] = null;
                flag_delete = true;
            }
        }
    } while (flag_delete == true)
    return true;
}


/***********************************************************************************************************************/
$('#evts').jstree({
    'core': {
        'data': <?php echo  $tree; ?>
    },


    "search": {
        "case_insensitive": true,

    },
    plugins: ["search", "html_data"]

});


/***********************************************************************************************************************/
$('#evts')
    .on("changed.jstree", function(e, data) {

        var x = document.getElementById("KStargets");
        var option = document.createElement("option");
        var h = document.getElementById("add");


        if (h.checked) {
            CurrentNode = $("#evts").jstree("get_selected");
            option.text = $('#' + CurrentNode).text();
            var opt = option.text;
            if ($('#KStargets option:contains(' + opt + ')').length)
                alert('noeud exists in your KS List');
            else
                x.add(option);
        }


    });


/***********************************************************************************************************************/

$('#addToSelection')
    .on("click", function() {

        //  alert( $('#evts').jstree().get_node.selected[0].text);
        var x = document.getElementById("KStargets");
        var option = document.createElement("option");

        var CurrentNode = $("#evts").jstree("get_selected")[0];
        option.text = CurrentNode;

        //var optionExists = ($("#KStargets option[value=1]").length > 0);

        var opt = option.text;
        if ($('#KStargets option:contains(' + opt + ')').length)
            alert('noeud déja sélectionné');
        else
            x.add(option);





    });

/***********************************************************************************************************************/
$('#Search').keyup(function() {
    $('#evts').jstree('search', $(this).val());
});


/***********************************************************************************************************************/
/*
$("#evts").on("select_node.jstree", function(evt, data) {



        var json = <?php echo $tree; ?>;
        var find = $("#evts").jstree("get_selected")[0];

        /*********************************************************************************************************** */
/*
        var table = document.getElementById("resourceslinks");
        while (table.firstChild) {
            table.removeChild(table.firstChild);
        }

        /*********************************************************************************************************** */

/*      for (var i = 0; i < json["objects"].length; i++) {


          if ((json["objects"][i]["name"] == find)) {

              var name = json["objects"][i]["relations"]["hasTraining"];

              for (var j = 0; j < name.length; j++) {


                  var row = table.insertRow(0);
                  var newCell1 = row.insertCell(0);
                  var newCell2 = row.insertCell(1);
                  newCell1.innerHTML = name.length - j;
                  newCell2.innerHTML = name[j];
              }
          }
      }

      var row = table.insertRow(0);
      var newCell1 = row.insertCell(0);
      var newCell2 = row.insertCell(1);
      newCell1.innerHTML = "<b>#</b>";
      newCell2.innerHTML = "<b>Resource Name</b>";


      /***********************************************************************************************************/
var table = document.getElementById("resourceslinks2");
while (table.firstChild) {
    table.removeChild(table.firstChild);
}

for (var i = 0; i < json["objects"].length; i++) {


    if ((json["objects"][i]["name"] == find)) {

        var require = json["objects"][i]["relations"]["requires"];
        var complexification = json["objects"][i]["relations"]["isComplexificationOf"];
        var nodename = json["objects"][i]["name"];
        var nodetype = json["objects"][i]["type"];




        var row = table.insertRow(0);
        var newCell1 = row.insertCell(0);
        newCell1.innerHTML = "<b>Is Complexification of: </b>" + complexification;



        var row = table.insertRow(0);
        var newCell1 = row.insertCell(0);
        newCell1.innerHTML = " <b>Require: </b>" + require;

        var row = table.insertRow(0);
        var newCell1 = row.insertCell(0);
        newCell1.innerHTML = "<b>Node Type: </b>" + nodetype;


        var row = table.insertRow(0);
        var newCell1 = row.insertCell(0);
        newCell1.innerHTML = "<b>Node Name: </b>" + nodename;

    }
}




/***********************************************************************************************************/

}




);

/******************************************************************************************************************* */

function PostSelect(formulaire) {
    var selectb = formulaire.elements["KStargets[]"];

    // On compte le nombre d'item de la liste select
    NbCol = selectb.length;

    // On lance une boucle pour selectionner tous les items
    for (var a = 0; a < NbCol; a++) {
        selectb.options[a].selected = "selected";
    }

    // On soumet le formulaire
    formulaire.submit();
}