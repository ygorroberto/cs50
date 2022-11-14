{% extends "layout.html" %}

{% block body %}

{% with messages = get_flashed_messages() %}
{% if messages %}
{% for message in messages %}
<div class="d-grid mb-3">
  <small class="text-success"><b>{{ message }}</b></small>
</div>
{% endfor %}
{% endif %}
{% endwith %}

<h2>Contacts</h2>

<a href="/register_agenda" class="btn btn-success">New</a>

<div class="col-md-12">
  <table class="table">
    <thead>
      <tr>
        <th>#ID</th>
        <th>Name</th>
        <th>Whatsapp number</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {% for row in contacts %}
      <tr>
        <td>{{ row.id }}</td>
        <td>{{ row.name }}</td>
        <td>{{ row.cell_phone }}</td>
        <td class="form-inline">
          <a href="#" class="btn btn-primary pull-right mr-1" data-toggle="modal" data-target="#editModal-{{ row.id }}"><i class="fa-solid fa-eye"></i> Show</a>
          <form action="/remove_agenda/{{ row.id }}/remove" method="post">
            <input type="submit" class="btn btn-danger mr-1" value="Delete" data-toggle="modal" data-target="#deleteModal-{{ row.id }}">
          </form>
          {% if row.cell_phone %}
            <a href="/api_whatsapp/{{ row.id }}" class="btn btn-success pull-right mr-1" target="_blank"><i class=""><i> Whatsapp message</a>
          {% else %}
            <a href="/api_whatsapp/{{ row.id }}" class="btn btn-success pull-right mr-1 disabled"><i class=""><i> Whatsapp message</a>
          {% endif %}
        </td>
      </tr>

      <div class="modal fade" id="editModal-{{ row.id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Show Account</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <form method="post" action="/edit_agenda/{{ row.id }}/update">
                <div class="form-group">
                  <label for="name" class="form-label">Name</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{ row.name }}">
                </div>
                <div class="form-group">
                  <label for="address" class="form-label">Address</label>
                  <input type="text" class="form-control" name="address" id="address" value="{{ row.address }}">
                </div>
                <div class="form-group">
                  <label for="number" class="form-label">Number</label>
                  <input type="number" class="form-control" name="number" id="number" value="{{ row.number_address }}">
                </div>
                <div class="form-group">
                  <label for="obs_address" class="form-label">Comp. Address</label>
                  <input type="text" class="form-control" name="obs_address" id="obs_address" value="{{ row.obs_address }}">
                </div>

                <div class="form-group">
                  <label for="phone_number" class="form-label">Phone Number</label>
                  <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ row.phone }}">
                </div>

                <div class="form-group">
                  <label for="cell_phone" class="form-label">Whatsapp number</label>
                  <input type="text" class="form-control" name="cell_phone" id="cell_phone" value="{{ row.cell_phone }}">
                </div>

                <div class="form-group">
                  <label for="email" class="form-label">E-mail</label>
                  <input type="email" class="form-control" name="email" id="email" value="{{ row.email }}">
                </div>

                <div class="form-group">
                  <label for="third_contact_name" class="form-label">Third Name Contact</label>
                  <input type="text" class="form-control" name="third_contact_name" id="third_contact_name" value="{{ row.name_contact }}">
                </div>

                <div class="form-group">
                  <label for="third_phone_number" class="form-label">Third Phone Number</label>
                  <input type="text" class="form-control" name="third_phone_number" id="third_phone_number" value="{{ row.phone_contact }}">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="deleteModal-{{ row.id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete!</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Are you sure to delete?</div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <a class="btn btn-primary" href="/remove_agenda">Delete</a>
            </div>
          </div>
        </div>
      </div>

      {% endfor %}
    </tbody>
  </table>
</div>

{% endblock %}