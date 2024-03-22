
var G_InitialCntFlg = 0;


function init()
{
    if (G_InitialCntFlg == 0)
    {
        G_TargetMode = 1;

        document.getElementById('TorqueDisplay').setAttribute("style", "display:block;");
        document.getElementById('AngleDisplay').setAttribute("style","display:none;");
    }

    G_InitialCntFlg ++;

}

function FunctionKey(Keyno)
{
    if (Keyno == "Torque")
    {
        document.getElementById('TorqueDisplay').setAttribute("style", "display:block;");
        document.getElementById('AngleDisplay').setAttribute("style","display:none;");
        $('#bnt2').removeClass('selected');
        $('#bnt1').addClass('selected');
    }
    else if (Keyno == "Angle")
    {
        document.getElementById('AngleDisplay').setAttribute("style","display:block;");
        document.getElementById('TorqueDisplay').setAttribute("style", "display:none;");
        $('#bnt1').removeClass('selected');
        $('#bnt2').addClass('selected');

    }
    else
    {
        alert("Function ["+ keyno +"] is under constructing ...");
    }
}