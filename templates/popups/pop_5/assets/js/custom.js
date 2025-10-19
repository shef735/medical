
$('.cancel').on('click', function()
{
    $('.popup').removeClass('fadedown');
    $('.popup').addClass('fadeup');

    setTimeout(function()
    {
        $('.popup').addClass('fadedown');
        $('.popup').removeClass('fadeup');
    }, 1000)
})
