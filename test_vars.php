<!DOCTYPE html>
<html>
    <head>
        <style>
            hr {
                margin-top: 20px; 
                margin-bottom: 20px;
            }
            table {
                border-color:black; 
                border-style:solid; 
                border-width:1px;
            }
            th {
                text-align: left; 
                background-color:black; 
                border-style:solid; 
                color:white; 
                padding-left:10px;
            }
            td {
                border-color:black;
                border-style:solid;
                border-width:1px; 
                padding-left: 3px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>PHP Server Vars</h1>
        </header>
        <hr>
        <section>
            <h2>Working dir (Long)</h2>
            <em><?php echo $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']); ?></em>
            <h2>Working dir (Short)</h2>
            <em><?php echo __DIR__ ?></em>
        </section>
        <hr>
        <section>
            <h2>$_SERVER attributes</h2>
            <table>
                <thead>
                    <tr>
                        <th>var_Name</th>
                        <th>var_Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($_SERVER as $param => $value) {
                    ?>
                        <tr>
                            <td><strong><?php echo $param; ?></strong></td>
                            <td><em><?php echo $value; ?></em></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <hr>
        <section>
            <h2>PHP Extensions version numbers</h2>
            <table>
                <thead>
                    <tr>
                        <th>var_Name</th>
                        <th>var_Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach (get_loaded_extensions() as $ext) {
                    ?>
                        <tr>
                            <td><strong><?php echo $ext; ?></strong></td>
                            <td><em><?php echo phpversion($ext); ?></em></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </body>
</html>
