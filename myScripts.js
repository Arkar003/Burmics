var tabBtns = document.querySelectorAll(".tab-box .btn-box button");
var tabPanel = document.querySelectorAll(".tab-box .panel")

function showPanel(panelIndex, colorCode){
    tabBtns.forEach(function(node){
        node.style.backgroundColor="";
        node.style.color="";
    });

    tabBtns[panelIndex].style.backgroundColor=colorCode;
    tabBtns[panelIndex].style.color="white";

    tabPanel.forEach(function(node){
        node.style.display="none";
    });

    tabPanel[panelIndex].style.display="block";
    tabPanel[panelIndex].style.backgroundColor=colorCode;
}

showPanel(0,'#f44336');