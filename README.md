<title>Home</title>
<h2>Website</h2>

<button>test button</button>



<form>
    <input placeholder=input...>
</form>




<table>
    <tr>
        <th>a</th>
        <th>b</th>
        <th>c</th>
    </tr>
    <tr>
        <td>ss</td>
    </tr>
</table>






<table class="table table-striped" id="searchPeople">
                    <thead>
                        <tr>
                            <th>People_ID</th>
                            <th>People_name</th>
                            <th>People_address</th>
                            <th>People_license</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($people as $person) { ?>
                            <tr>
                                <td><?php echo $person["People_ID"]; ?></td>
                                <td><?php echo $person["People_name"]; ?></td>
                                <td><?php echo $person["People_address"]; ?></td>
                                <td><?php echo $person["People_licence"]; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>



<table>
    <thead>
        <tr>
            <th>People_ID</th>
            <th>People_name</th>
            <th>People_address</th>
            <th>People_license</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>id test</td>
            <td><?php echo $person["People_name"]; ?></td>
            <td><?php echo $person["People_address"]; ?></td>
            <td><?php echo $person["People_licence"]; ?></td>
        </tr>
    </tbody>
</table>

