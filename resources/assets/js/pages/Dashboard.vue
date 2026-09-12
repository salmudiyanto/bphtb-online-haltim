<template>
  <div>
    <h2>Dashboard BPHTB Online</h2>
    <div class="row" style="margin-top: 20px;">
      <div class="col-md-4">
        <div class="panel panel-info">
          <div class="panel-heading">Total Transaksi</div>
          <div class="panel-body">
            <h3>0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-success">
          <div class="panel-heading">Terverifikasi</div>
          <div class="panel-body">
            <h3>0</h3>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-warning">
          <div class="panel-heading">Pending</div>
          <div class="panel-body">
            <h3>0</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Dashboard'
};
</script>
