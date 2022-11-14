{% extends "layout.html" %}

{% block body %}

<h2>Edit Account</h2>
{% for row in account %}
<div class="col-md-12">
  <form method="post" action="/edit_account/{{ row.id }}/update">
    <div class="form-group">
      <label for="account" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" id="name" value="{{ row.full_name }}">
    </div>
    <div class="form-group">
      <label for="account" class="form-label">Login</label>
      <input type="text" class="form-control" name="login" id="login" value="{{ row.login }}">
    </div>
    <div class="form-group">
      <label for="account" class="form-label">E-mail</label>
      <input type="email" class="form-control" name="email" id="email" value="{{ row.email }}">
    </div>
    <div class="form-group">
      <label for="account" class="form-label">Password</label>
      <input type="text" class="form-control" name="password" id="password" value="{{ row.password }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="/account" class="btn btn-secondary">Voltar</a>
  </form>
</div>
{% endfor %}

{% endblock %}