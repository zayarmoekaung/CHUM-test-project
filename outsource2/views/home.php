<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.png">
    <title>CHUM's Queue Admin Sys</title>
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css">
</head>

<body>

<header class="navbar">
<section class="navbar-section">
<select name="consumerType" id="contype">
<option value="All" selected disabled>Consumer Type</option> 
</select>
<select name="Queue Status" id="qstatus">
<option value="All" selected disabled>Queue Status</option>  
<option value="Waiting for consumer">waiting For Consumer</option>


<option value="Working on consumer">Working on consumer</option>


<option value="Work done Successfully">Work Done Successfully</option>


<option value="Work done Error">Work Done Error</option>


</select>
</section>
  <section class="navbar-section">
  <form action="<?php echo $routes->get('homepage')->getPath(); ?>" method='POST'>
    <div class="input-group input-inline">
      <input  class="form-input" type="text" placeholder="request Id" name="requestId">
      <button type="submit" class="btn btn-primary input-group-btn">Search</button>
    </div>
</form>
    <button  class="btn btn-primary input-group-btn"  onClick="window.location.reload();"><i class="icon icon-refresh"></i></button>
  </section>
</header>
<table class="table">
  <thead>
    <tr>
      <th>Request Id</th>
      <th>Status</th>
      <th>consumer Type</th>
      <th>Message </th>
      <th>Priority</th>
      <th>Result Url</th>
      <th>Requester Id</th>
      <th>Consumer Id</th>  
    </tr>
  </thead>
  <tbody>
   
   <?php  foreach ($reqs as $item): ?>

    <tr >
      <td><?php echo( $item['requestId']['S']); ?></td>
      <td><?php echo( $item['qstatus']['S']); ?></td>
      <td><?php echo( $item['consumerType']['S']); ?></td>
      <td><?php echo( $item['message']['S']); ?></td>
      <td><?php echo( $item['priority']['S']); ?></td>
      <td><?php echo( $item['resultUrl']['S']); ?></td>
      <td><?php echo( $item['requesterId']['S']); ?></td>
      <td><?php echo( $item['consumerId']['N']); ?></td>  
    </tr>
   <?php endforeach; ?>  
   
  </tbody>
</table>
   
</body>


<script>
 
</script>
</html>