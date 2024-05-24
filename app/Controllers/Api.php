namespace App\Controllers;
use App\MyClass\User;

class Api extends BaseController
{
// Affiche la vue de l'index de l'API
public function getIndex()
{
return $this->view('api\index');
}

public $acl = false;
protected $start_session = false;

// Récupère toutes les pizzas avec leurs ingrédients
public function getAllPizza()
{
$pizzaModel = model('PizzaModel');
$allPiza = $pizzaModel->getPizzasWithIngredients();
return $this->json($allPiza);
}

// Crée une nouvelle commande avec les données fournies dans le corps de la requête
public function postMakeCommande()
{
$requestBody = $this->request->getBody();
$data = json_decode($requestBody, true);

// Vérifie si l'ID du client est présent dans les données
if (isset($data['id_client'])) {
$id_client = $data['id_client'];

// Insère une nouvelle commande dans la base de données
$commandeModel = model('CommandeModel');
$id_commande = $commandeModel->insertCommande(['id_client' => $id_client]);
} else {
return $this->json(['error' => 'id_client is missing in request body'], 400);
}

// Vérifie si les informations sur la pizza sont présentes dans les données
if (isset($data['pizza'])) {
$commandeModel = model('CommandeModel');
$commandeModel->insertLigneCommande($id_commande, $data['pizza']);
return $this->json(['success' => 'La commande ' . $id_commande . ' a bien été effectuée.'], 200);
} else {
return $this->json(['error' => 'id_client is missing in request body'], 400);
}
}

// Récupère une commande par l'ID du client fourni dans les paramètres de la requête
public function getCommande()
{
$idUrl = (int)$this->request->getVar('id');

if ($idUrl != null) {
$commandeModel = model('CommandeModel');
$commande = $commandeModel->getCommandeByIdClient($idUrl);
if ($commande != null) {
return $this->json($commande);
} else {
return $this->json(["error" => "Commande not found"], 500);
}
} else {
return $this->json(["error" => "ID not found"], 500);
}
}

// Récupère une pizza par l'ID fourni dans les paramètres de la requête
public function getPizza()
{
$idUrl = (int)$this->request->getVar('id');

if ($idUrl != null) {
$pizzaModel = model('PizzaModel');
$pizza = $pizzaModel->getPizzaById($idUrl);
if ($pizza != null) {
return $this->json($pizza);
} else {
return $this->json(["error" => "Pizza not found"], 500);
}
} else {
return $this->json(["error" => "ID not found"], 500);
}
}

// Gère la connexion d'un utilisateur
public function getLogin() {
if (($email = $this->request->getVar('email')) !== null
&& ($pass = $this->request->getVar('password')) !== null) {
$userModel = model('UserModel');
$candidateData = $userModel->getUserByMail($email);

if ($candidateData) {
// Crée un objet User avec les données récupérées
$candidate = new User(
$candidateData['id'],
$candidateData['username'],
$candidateData['email'],
$candidateData['password'],
$candidateData['admin'],
$candidateData['active'],
$candidateData['auth_attempt'],
$candidateData['photo']
);

} else {
return $this->json(["error" => "User not found"],500);
}
if ($candidate) {
if ($candidate->getActive()) {

// Vérifie si le mot de passe est correct
if (password_verify(
$pass,
$candidate->getPassword()
)) {
return $this->json(["id_user" => $candidate->getId()]);
} else {
$candidate->auth_attempt++;
if ($candidate->auth_attempt > 5) {
return $this->json(["error" => "User blocked, please contact an administrator"], 500);
}
return $this->json(["error" => "Password incorrect", "auth_attempt" => $candidate->auth_attempt], 500);
}
}
}

$this->redirect('Login');
}
}
}
