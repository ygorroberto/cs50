from flask import Flask, render_template, redirect, request, session, flash
# The Session instance is not used for direct access, you should always use flask.session
from flask_session import Session
import sqlite3

app = Flask(__name__)
app.config["SESSION_PERMANENT"] = False
app.config["SESSION_TYPE"] = "filesystem"
Session(app)

# connection factory
def get_db_connection():

    conn = sqlite3.connect("teste.db", check_same_thread=False)
    conn.row_factory = sqlite3.Row
    return conn

@app.route("/")
def index():
	if not session.get("name"):
		return redirect("/login")
	return render_template('index.php')

@app.route("/login", methods=["POST", "GET"])
def login():

    conn = get_db_connection()

    if request.method == "POST":
        # session
        # session["name"] = request.form.get("login")
        
        # requests
        login = request.form.get("login")
        password = request.form.get("password")

        # se algum campo estiver em branco retorna erro
        if not login or not password:
            return render_template("login.php", message="Login inválido!", text_class="danger")

        # busca algum usuário com a account e password digitados
        account = conn.execute("SELECT * FROM accounts WHERE login = ? AND password = ?", (login, password)).fetchall()
        conn.close()

        for row in account:
            session["name"] = row["full_name"]
            session["email"] = row["email"]

        # se tiver uma conta conforme o que foi digitado, sucesso
        if account:
            return redirect("/")
        else:
            return render_template("login.php", message="Login inválido!", text_class="danger")        
            
    return render_template("login.php")

@app.route("/register", methods=["POST", "GET"])
def register():

    if not session.get("name"):
        return redirect("/login")

    conn = get_db_connection()

    if request.method == "POST":
        # requests
        full_name = request.form.get("name")
        login = request.form.get("login")
        email = request.form.get("email")
        password = request.form.get("password")
        password_repeat = request.form.get("password_repeat")

        # se existir algum campo em branco, erro
        if not full_name or not login or not email or not password or not password_repeat:
            return render_template("register.php", message="Preencha todos os campos!", text_class="danger")
        # se o password for diferente do password_repeat, erro
        elif password != password_repeat:
            return render_template("register.php", message="As senhas devem ser iguais!", text_class="danger")
        
        # busca alguma conta com o mesmo login
        accounts = conn.execute("SELECT * FROM accounts WHERE login = ?", [login]).fetchall()

        # se já existir a conta, erro
        if accounts:
            return render_template("register.php", message="Já existe uma conta com este número!", text_class="danger")
        else:
            conn.execute("INSERT INTO accounts (login, password, full_name, email) VALUES (?, ?, ?, ?)", (login, password, full_name, email))
            conn.commit()
            conn.close()
            return render_template("register.php", message="Cadastro realizado com sucesso!", text_class="success")

    return render_template("register.php")

@app.route("/account")
def account():

    conn = get_db_connection()

    # busca alguma conta com o mesmo account
    accounts = conn.execute("SELECT * FROM accounts").fetchall()
    conn.close()

    return render_template("account.php", accounts=accounts)

@app.route("/edit_account/<id>/update", methods=["POST", "GET"])
def edit_account(id):

    conn = get_db_connection()

    account = conn.execute("SELECT * FROM accounts WHERE id = ?", [id]).fetchall()
    # conn.close()

    if request.method == "POST":

        name = request.form.get("name")
        login = request.form.get("login")
        email = request.form.get("email")
        password = request.form.get("password")
        
        conn.execute("UPDATE accounts SET full_name = ?, login = ?, email = ?, password = ? WHERE id = ?", (name, login, email, password, id))
        conn.commit()
        conn.close()
        return redirect("/account")

    return render_template("edit_account.php", account=account)

@app.route("/remove_account/<id>/remove", methods=["POST"])
def remove_account(id):

    conn = get_db_connection()

    if request.method == "POST":

        conn.execute("DELETE FROM accounts WHERE id = ?", [id])
        conn.commit()
        conn.close()
        flash("Registro removido com sucesso!")

    return redirect("/account")

@app.route("/profile", methods=["GET"])
def profile():

    return render_template("profile.php")

@app.route("/agenda", methods=["POST", "GET"])
def agenda():

    conn = get_db_connection()

    # busca alguma conta com o mesmo account
    contacts = conn.execute("SELECT * FROM agenda").fetchall()
    conn.close()

    return render_template("agenda.php", contacts=contacts)

@app.route("/register_agenda", methods=["POST", "GET"])
def register_agenda():

    if not session.get("name"):
        return redirect("/login")

    conn = get_db_connection()

    if request.method == "POST":
        # requests
        name = request.form.get("name")
        address = request.form.get("address")
        number = request.form.get("number")
        obs_address = request.form.get("obs_address")
        phone_number = request.form.get("phone_number")
        cell_phone = request.form.get("cell_phone")
        email = request.form.get("email")
        third_contact_name = request.form.get("third_contact_name")
        third_phone_number = request.form.get("third_phone_number")

        # se existir algum campo em branco, erro
        if not name:
            return render_template("register_agenda.php", message="Campos obrigatórios!", text_class="danger")
        
        # busca alguma conta com o mesmo login
        contact = conn.execute("SELECT * FROM agenda WHERE name = ?", [name]).fetchall()

        # se já existir a conta, erro
        if contact:
            return render_template("register_agenda.php", message="Este nome já existe na agenda!", text_class="danger")
        else:
            conn.execute("INSERT INTO agenda (name, address, number_address, obs_address, cell_phone, phone, email, phone_contact, name_contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", (name, address, number, obs_address, cell_phone, phone_number, email, third_phone_number, third_contact_name))
            conn.commit()
            conn.close()
            return redirect("/agenda")
            # return render_template("agenda.php", message="Cadastro realizado com sucesso!", text_class="success")

    return render_template("register_agenda.php")

@app.route("/edit_agenda/<id>/update", methods=["POST", "GET"])
def edit_agenda(id):

    if not session.get("name"):
        return redirect("/login")

    conn = get_db_connection()

    contacts = conn.execute("SELECT * FROM agenda").fetchall()
    # conn.close()

    if request.method == "POST":

        name = request.form.get("name")
        address = request.form.get("address")
        number_address = request.form.get("number_address")
        obs_address = request.form.get("obs_address")
        cell_phone = request.form.get("cell_phone")
        phone = request.form.get("phone")
        email = request.form.get("email")
        phone_contact = request.form.get("phone_contact")
        name_contact = request.form.get("name_contact")
        
        conn.execute("UPDATE agenda SET name = ?, address = ?, number_address = ?, obs_address = ?, cell_phone = ?, phone = ?, email = ?, phone_contact = ?, name_contact = ? WHERE id = ?", (name, address, number_address, obs_address, cell_phone, phone, email, phone_contact, name_contact, id))
        conn.commit()
        conn.close()
        return redirect("/agenda")

    return render_template("agenda.php", contacts=contacts)

@app.route("/remove_agenda/<id>/remove", methods=["POST"])
def remove_agenda(id):

    if not session.get("name"):
        return redirect("/login")

    conn = get_db_connection()

    if request.method == "POST":

        conn.execute("DELETE FROM agenda WHERE id = ?", [id])
        conn.commit()
        conn.close()
        flash("Registro removido com sucesso!")

    return redirect("/agenda")

@app.route("/api_whatsapp/<id>", methods=["POST", "GET"])
def api_whatsapp(id):

    if not session.get("name"):
        return redirect("/login")

    conn = get_db_connection()

    if request.method == "GET":

        # print(id)

        contacts = conn.execute("SELECT * FROM agenda WHERE id = ?", [id]).fetchone()
        conn.commit()
        conn.close()

        if contacts["cell_phone"]:
            return redirect("https://api.whatsapp.com/send?phone=" + contacts["cell_phone"])
        
    return redirect("/agenda")

@app.route("/logout")
def logout():
	session["name"] = None
	return redirect("/")

if __name__ == "__main__":
	app.run(debug=True)
