<div id="tools-box">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
        <a href="#">
          <h3 class="panel-title"><span class="glyphicon glyphicon-education"></span>Utilidades</h3>
        </a>
      </div>
      <div class="panel-body">
        <div class="jumbotron2">
          <h1>Meta4 File Upload</h1>
          <form method="post" action="/tools/meta4" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="file" name="file" required>
            <button class="btn btn-primary" type="submit">Subir archivo</button>
          </form>
        </div>
      </div>
      <div class="panel-footer">

      </div>
    </div>
</div>