{% extends "layout.html" %}

{% block body %}

<h2>Register Contact</h2>

<div class="d-grid mb-3">
  <small class="text-{{ text_class }}"><b>{{ message }}</b></small>
</div>

<div class="col-md-12">
  <form method="post" action="/register_agenda">
    <div class="form-group">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" id="name" value="" autofocus>
    </div>
    <div class="form-group">
      <label for="address" class="form-label">Address</label>
      <input type="text" class="form-control" name="address" id="address" value="">
    </div>
    <div class="form-group">
      <label for="number" class="form-label">Number</label>
      <input type="number" class="form-control" name="number" id="number" value="">
    </div>
    <div class="form-group">
      <label for="obs_address" class="form-label">Comp. Address</label>
      <input type="text" class="form-control" name="obs_address" id="obs_address" value="">
    </div>

    <div class="form-group">
      <label for="phone_number" class="form-label">Phone Number</label>
      <input type="text" class="form-control" name="phone_number" id="phone_number" value="">
    </div>

    <div class="form-group">
      <label for="cell_phone" class="form-label">Whatsapp number</label>
      <input type="text" class="form-control" name="cell_phone" id="cell_phone" value="">
    </div>

    <div class="form-group">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" class="form-control" name="email" id="email" value="">
    </div>

    <div class="form-group">
      <label for="third_contact_name" class="form-label">Third Name Contact</label>
      <input type="text" class="form-control" name="third_contact_name" id="third_contact_name" value="">
    </div>

    <div class="form-group">
      <label for="third_phone_number" class="form-label">Third Phone Number</label>
      <input type="text" class="form-control" name="third_phone_number" id="third_phone_number" value="">
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="/agenda" class="btn btn-secondary">Back</a>
  </form>
</div>

{% endblock %}