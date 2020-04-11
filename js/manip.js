function openNav() {
    if (openside) {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
        openside = false;
    } else {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
        openside = true;
    }
}

/***********************************************************************************************************************/

function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    document.getElementById("main").style.marginLeft = "0";
}

/***********************************************************************************************************************/

function keepopen() {
    document.getElementById("mySidebar").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
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
    } while (flag_delete == true);

    return true;
}

/***********************************************************************************************************************/

$(function() {
    $("#draggable1").draggable();
});

$(function() {
    $("#draggable2").draggable();
});

$(function() {
    $("#draggable3").draggable();
});

$(function() {
    $("#draggable4").draggable();
});

$(function() {
    $("#draggable5").draggable();
});
/***********************************************************************************************************************/
/***********************************************************************************************************************/
/***********************************************************************************************************************/

$("#Tree").jstree({
    core: {
        data: treeview
    },

    search: {
        case_insensitive: true,
        show_only_matches: false
    },
    plugins: ["search", "html_data"]
});

/***********************************************************************************************************************/

//$('#Tree').jstree().on('ready.jstree', function(){ $(this).jstree('open_all') });

$("#Tree").on("ready.jstree", function() {
    $("#Tree").jstree("open_all");
});
/***********************************************************************************************************************/
$("#Tree").on("select_node.jstree", function(e, data) {
    var h = document.getElementById("AutoAdd");

    if (h.checked) {
        var x = document.getElementById("KStargets");

        var option = document.createElement("option");

        var CurrentNode = $("#Tree").jstree("get_selected")[0];

        option.text = CurrentNode;

        var opt = option.text;

        if ($("#KStargets option:contains(" + opt + ")").length)
            alert("object already exists");
        else {
            option.setAttribute("selected", true);
            x.add(option);
        }
    }

    var node_id = data.node.id;
    NodeType = $("#" + node_id).attr("description");
});

/***********************************************************************************************************************/

$("#addToSelection").on("click", function() {
    if (NodeType == "Competency")
        alert("you can't add a competency to the selected list");
    else {
        var x = document.getElementById("KStargets");

        var option = document.createElement("option");

        var CurrentNode = $("#Tree").jstree("get_selected")[0];
        option.text = CurrentNode;

        var opt = option.text;
        if ($("#KStargets option:contains(" + opt + ")").length)
            alert("object already exists");
        else {
            option.setAttribute("selected", true);
            x.add(option);
        }
    }
});

/***********************************************************************************************************************/

/***********************************************************************************************************************/

$("#Search").keyup(function() {
    $("#Tree").jstree("search", $(this).val());
});

/***********************************************************************************************************************/

$("#Tree").on("select_node.jstree", function(evt, data) {
    var json = source;

    var Fif = json["frameworkId"];

    var find = $("#Tree").jstree("get_selected")[0];

    /***********************************************************************************************************************/


    var table = document.getElementById("resourceslinks");
    while (table.firstChild) {
        table.removeChild(table.firstChild);
    }

    /***********************************************************************************************************************/

    for (var i = 0; i < json["objects"].length; i++) {
        if (json["objects"][i]["name"] == find) {
            var name = json["objects"][i]["relations"]["hasTraining"];

            for (var j = 0; j < name.length; j++) {
                var row = table.insertRow(0);
                var newCell1 = row.insertCell(0);
                var newCell2 = row.insertCell(1);
                newCell1.innerHTML =
                    '<a href="controller/controller.php?deletelink=true&frameworkId=' +
                    Fif +
                    "&resource=" +
                    name[j] +
                    "&relation=hasTraining&object=" +
                    find +
                    '"  title="delete link"  onclick="return confirm(\'Are you sure you want to unlink this resource?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                newCell2.innerHTML = name[j];
            }

            name = json["objects"][i]["relations"]["hasLearning"];

            for (var j = 0; j < name.length; j++) {
                var row = table.insertRow(0);
                var newCell1 = row.insertCell(0);
                var newCell2 = row.insertCell(1);
                newCell1.innerHTML =
                    '<a href="controller/controller.php?deletelink=true&frameworkId=' +
                    Fif +
                    "&resource=" +
                    name[j] +
                    "&relation=hasLearning&object=" +
                    find +
                    '"  title="delete link"  onclick="return confirm(\'Are you sure you want to unlink this resource?\')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                newCell2.innerHTML = name[j];
            }
        }
    }

    var row = table.insertRow(0);
    var newCell1 = row.insertCell(0);
    var newCell2 = row.insertCell(1);
    newCell1.innerHTML = "<b> </b>";
    newCell2.innerHTML = "<b>Resource Identifier</b>";

    /***********************************************************************************************************************/

    var table = document.getElementById("resourceslinks2");
    while (table.firstChild) {
        table.removeChild(table.firstChild);
    }

    /***********************************************************************************************************************/


    for (var i = 0; i < json["objects"].length; i++) {
        if (json["objects"][i]["name"] == find) {
            var require = json["objects"][i]["relations"]["requires"]; // add text as a list of lines

            var complexification =
                json["objects"][i]["relations"]["isComplexificationOf"]; // add text as a list of lines
            var IsLevelOUnderstanding =
                json["objects"][i]["relations"]["isLeverOfUnderstandingOf"]; // add text as a list of lines
            var nodename = json["objects"][i]["name"];
            var nodetype = json["objects"][i]["type"];

            /******************************************************************* */

            var row = table.insertRow(0);
            var newCell1 = row.insertCell(0);
            var str = "";
            for (var j = 0; j < IsLevelOUnderstanding.length; j++)
                str = str + IsLevelOUnderstanding[j] + "<br>";
            newCell1.innerHTML = "<b>Is Levelof Understanding: </b><br>" + str;

            /******************************************************************* */
            var row = table.insertRow(0);
            var newCell1 = row.insertCell(0);
            var str = "";
            for (var j = 0; j < complexification.length; j++)
                str = str + complexification[j] + "<br>";
            newCell1.innerHTML = "<b>Is Complexification of: </b><br>" + str;
            /******************************************************************* */

            var row = table.insertRow(0);
            var newCell1 = row.insertCell(0);
            var str = "";
            for (var j = 0; j < require.length; j++) str = str + require[j] + "<br>";
            newCell1.innerHTML = " <b>Require: </b><br>" + str;
            /******************************************************************* */

            var row = table.insertRow(0);
            var newCell1 = row.insertCell(0);
            newCell1.innerHTML = "<b>Node Type: </b>" + nodetype;
            /******************************************************************* */

            var row = table.insertRow(0);
            var newCell1 = row.insertCell(0);
            newCell1.innerHTML = "<b>Node Name: </b>" + nodename;
        }
    }

});

/***********************************************************************************************************************/