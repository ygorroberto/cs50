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

<h2>Accounts</h2>

<a href="/register" class="btn btn-success">New</a>

<div class="col-md-12">
  <table class="table">
    <thead>
      <tr>
        <th>#ID</th>
        <th>Account Name</th>
        <th>Login</th>
        <th>E-mail</th>
        <th>Password</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {% for row in accounts %}
      <tr>
        <td>{{ row.id }}</td>
        <td>{{ row.full_name }}</td>
        <td>{{ row.login }}</td>
        <td>{{ row.email }}</td>
        <td>{{ row.password }}</td>
        <td class="form-inline">
          <a href="/edit_account/{{ row.id }}/update" class="btn btn-primary pull-right mr-1">Edit</a>
          <form action="/remove_account/{{ row.id }}/remove" method="post">
            <!-- <input type="hidden" name="_method" value="DELETE"> -->
            <input type="submit" value="Delete" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
          </form>
        </td>
      </tr>
      {% endfor %}
    </tbody>
  </table>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <a class="btn btn-primary" href="/logout">Logout</a>
      </div>
    </div>
  </div>
</div>

{% endblock %}