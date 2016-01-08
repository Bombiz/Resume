$(document).ready(check);
function check()
{
  //blur needs to have a function otherwise it will call $.get right away
  $("#search").click(function()
  {
      var battleTag = document.getElementById("battletag").value;
      $.get("d3json.php", {"battleTag":battleTag}, getHeroes, "json");
  });
}

function getHeroes(heroes)
{
    $('p').remove();
    $('#heroes').empty();
    var output="<br><div id=\"paragon\">";
    var paragon = ("Paragon Level: " + heroes[0]);
    output+=paragon;
    output+="</div>";

    for(var i = 1; i < heroes.length; i++)
    {
	output+="<br>\n<div class=\"hero\">";
	output+="<a href=\"hero.php?hero="+heroes[i].name+"\">"+heroes[i].name+"</a>";
	output+=" - Level " + heroes[i].level + " " + heroes[i].class;
	output+="</div>";
    }

    //alert(output);
    $('#heroes').append(output);
 }
