<?php
    //STARTING SESSION
	if (!isset($_SESSION))
	{
		session_start();
	}
	
	//GLOBALS
    if (!isset($_SESSION['logged']))
    {
        $_SESSION['logged'] = false;
    }

    if (!isset($_SESSION['time']))
    {
        $_SESSION['time'] = 0;
    }

    if (!isset($_SESSION['curErr']))
    {
        $_SESSION['curErr'] = '';
    }
    
    if (!isset($_SESSION['cryptInfo']))
    {
        $_SESSION['cryptInfo'] = '';
    }
    
    if (!isset($_SESSION['curInf']))
    {
        $_SESSION['curInf'] = '';
    }
    
    if (!isset($_SESSION['curSuc']))
    {
        $_SESSION['curSuc'] = '';
    }
	
	if (!isset($_SESSION['registered']))
    {
        $_SESSION['registered'] = 0;
    }

    if (!isset($_SESSION['passLength']))
    {
        $_SESSION['passLength'] = 0;
    }

    if (!isset($_SESSION['constPassLength']))
    {
        $_SESSION['constPassLength'] = 0;
    }

    if (!isset($_SESSION['decryptedChars']))
    {
        $_SESSION['decryptedChars'] = 0;
    }
?>
