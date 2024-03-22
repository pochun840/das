var G_InitialCntFlg = 0;

function init()
{
    if (G_InitialCntFlg == 0)
    {
        G_InputTableMode = 1;

        document.getElementById('TableInput').setAttribute("style", "display:block;");
        document.getElementById('TableDataInput').setAttribute("style","display:none;");
    }

    G_InitialCntFlg ++;

}

function TableSubmit(Keyno)
{

    if (Keyno == "Table")
    {
        document.getElementById('TableDataInput').setAttribute("style", "display:block;");
        document.getElementById('TableInput').setAttribute("style","display:none;");
        job_input();
    }
    if (Keyno == "List")
    {
        document.getElementById('TableDataInput').setAttribute("style", "display:none;");
        document.getElementById('TableInput').setAttribute("style","display:block;");
        job_input();
    }
}