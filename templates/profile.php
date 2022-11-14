{% extends "layout.html" %}

{% block body %}

<h2>Profile</h2>
<div class="row">
  <div class="col-md-5">
    <figure class="figure">
      <img src="{{ url_for('static', filename='img/undraw_profile.svg') }}" class="figure-img img-fluid rounded" alt="...">
      <div class="mb-3">
        <input class="form-control" type="file" id="formFile">
      </div>
    </figure>
  </div>
  <div class="col-md-7">
    <div class="form-group">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" id="name" value="{{ session.name }}">
    </div>
    <div class="form-group">
      <label for="email" class="form-label">E-mail</label>
      <input type="text" class="form-control" name="email" id="email" value="{{ session.email }}">
    </div>
  </div>
</div>

{% endblock %}