$("#show_switcher").on('click', function()
{

    $('.switcher').toggleClass("switcher_visible");
})


function colorswitcher(colorschemenumber)
{
    var addLink = document.getElementsByTagName('head');
    var link = document.createElement('link');
    var colorscheme;

    if(colorschemenumber == 0)
    {
        // default style link
        colorscheme = "assets/css/colorvariants/default.css";
        $("#colorswitch").remove();
        $("#defaultscheme").remove();
    }
    else
    {
        // color variants link
        colorscheme = "assets/css/colorvariants/colorscheme-"+ colorschemenumber + ".css";
        $("#colorswitch").remove();
        $("#defaultscheme").remove();
    }


    $(link).attr
    (
        {
            rel: "stylesheet",
            href: colorscheme,
            id: "colorswitch",
        }
    )
    $(addLink).prepend(link);

}
$(".switch_color button").on('click', function()
{
    $(".switch_color button").removeClass('active-scheme');
    $(this).addClass('active-scheme');
})



$("#reset").on('click', function()
{
    colorswitcher(0);
}
)
$("#scheme1").on('click', function()
{
    colorswitcher(1);
}
)
$("#scheme2").on('click', function()
{
    colorswitcher(2);
}
)
$("#scheme3").on('click', function()
{
    colorswitcher(3);
}
)
$("#scheme4").on('click', function()
{
    colorswitcher(4);
}
)
$("#scheme5").on('click', function()
{
    colorswitcher(5);
}
)
$("#scheme6").on('click', function()
{
    colorswitcher(6);
}
)
$("#scheme7").on('click', function()
{
    colorswitcher(7);
}
)