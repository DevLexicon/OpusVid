/*
=====================================================================
	Donald Louch Portfolio | resume.js
	v. 2.0 | April 6th, 2017
=====================================================================
*/

console.log("toggle.js is working!")

function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }

/*
=====================================================================
Section Collaps
=====================================================================


var accordion = document.getElementsByClassName("accordion"); // Get's all elements with the tag "accordion"

for (var i = 0; i < accordion.length; i++) {
    accordion[i].onclick = function(){ // Adds "onclick" to all elements found in the variable "accordion"
        this.classList.toggle("active"); // When section is clicked it will toggle the panel as active OR inactive

        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none"; // When toogled off, content is not showing
            console.log("Not Toggled");
        } else {
            panel.style.display = "block"; //When toogled on, content is displayed as a block element
            console.log("You Toggled The Section!");
        }
    }
}

// Code adapted from https://www.w3schools.com/howto/howto_js_accordion.asp

/*
=====================================================================
	@ 2016 - 2017 Donald Louch Producrions
=====================================================================
*/
