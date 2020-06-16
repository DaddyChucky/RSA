<style>

    .notifs
    {
        text-align: center;
        padding-top: 4%;
        padding-bottom: 4%;
        border: 2px groove black;
        background: white;
        border-radius: 8px;
        margin: 2% 20% 5% 20%;
    }

    .notifs:hover
    {
        background: #FFEEEE;
        transition: ease-in-out 0.5s;
    }

</style>

<?php
    //IF ERROR, SHOW
    if (isset($_SESSION['curErr']) && $_SESSION['curErr'] != '')
    { 
    ?>
    <h3 class="notifs">
        <i class="material-icons" style="font-size: 44px; color: crimson;" >
            error
        </i>
        <br />
        <span style="font-family: 'Blinker', sans-serif;
        font-size: 20px;
        text-align: center;
        color: darkred;
        margin-right: 4%;
        margin-left: 4%;">
            <?php
                echo $_SESSION['curErr'];
                $_SESSION['curErr'] = '';
                session_destroy();
            ?>
        </span>
    </h3>
    <?php
    }

    else if (isset($_SESSION['curInf']) && $_SESSION['curInf'] != '')
    { 
    ?>
    <h3 class="notifs">
        <i class="material-icons" style="font-size: 44px; color: cornflowerblue;">
            info
        </i>
        <br />
        <span style="font-family: 'Blinker', sans-serif;
        font-size: 20px;
        text-align: center;
        color: darkblue;
        margin-right: 2%;
        margin-left: 2%;">
            <?php
                echo $_SESSION['curInf'];
                $_SESSION['curInf'] = '';
            ?>
        </span>
    </h3>
    <?php
    }

    else if (isset($_SESSION['curSuc']) && $_SESSION['curSuc'] != '')
    { 
    ?>
    <h3 class="notifs">
        <i class="material-icons" style="font-size: 44px; color: darkseagreen;">
            check_circle
        </i>
        <br />
        <span style="font-family: 'Blinker', sans-serif;
        font-size: 20px;
        text-align: center;
        color: darkolivegreen;
        margin-right: 2%;
        margin-left: 2%;">
            <?php
                echo $_SESSION['curSuc'];
                $_SESSION['curSuc'] = '';
            ?>
        </span>
    </h3>
    <?php
    }
?>