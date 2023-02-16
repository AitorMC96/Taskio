<?php
    // Permetem l'accés des de qualsevol origen
    header('Access-Control-Allow-Origin: *');
    require("./database.php");

    class server {
        private $database;
        
        public function serve() {
            $uri = $_SERVER['REQUEST_URI'];
            $method = $_SERVER['REQUEST_METHOD'];
            $ruta = explode("/", $this->ruta($uri));
            $accio = $ruta[2];

            switch ($accio) {
                case "login":
                    // Obtenim les dades JSON enviades a un endpoint de l'API
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    // 
                    $email = $data['email'];
                    // 
                    $password = $data['password'];
                    // Comprovem que el token es troba en la base de dades
                    if ($this->database->comprovarTaulaToken($accessToken)) {
                        // Comprovem que les dades de l'usuari són les mateixes que les de la base de dades
                        if ($this->database->comprovarUsuari($email, $password)) {
                            $accessToken = ($email, generarToken());
                            // Guardem el token actual a la base de dades
                            if ($this->database->tokenUsuari($accessToken, $email)) {
                                // 
                                header("Content-type: application/json");
                                $data = array('token' => $accessToken);
                                echo json_encode($data);
                            }
                            // Si no s'ha pogut inserir el token en la taula de dades de l'usuari
                            else {
                                //Retornem error 500
                                header('HTTP/1.1 500 Database error')
                            }
                        }
                        // Si les dades de l'usuari no coincideixen amb les dades de l'usuari guardades a la base de dades
                        else {
                            // Retornem error 401
                            header('HTTP/1.1 401 Unauthorized');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "obtenirToken":
                    // Obtenim les dades JSON enviades a un endpoint de l'API
                    $data = json_decode(file_get_contents('php://input'));
                    if ($data[''] == ()) {
                        $accessToken = generarToken();
                        if ($this->database->inserirToken($accessToken)) {
                            echo json_encode($accessToken);
                        }
                        // 
                        else {
                            echo json_encode(false);
                        }
                    }
                    //
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    // Retornem les dade en format JSON
                    header("Content-type: application/json");
                    break;
                /*=======
                 Tasques
                ========*/
                case "obtenirTasca":
                    // Obtenim les dades JSON enviades a un endpoint de l'API
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Guardem l'ID de la tasca que volem obtenir a la variable $tascaID
                    $tascaID = $data['tascaID'];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "administrador"
                        if ($rolUsuari["rol"] == "gestor" || $rolUsuari["rol"] == "administrador") {
                            // Cridem a la funció "obtenirTasca" i guardem el resultat "true" o "false" en una variable
                            $resultat = $this->database->obtenirTasca($tascaID);
                            // Si no existeix la tasca a la base de dades
                            if ($resultat == null) {
                                // Retornem error 403
                                header('HTTP/1.1 403 Forbidden');
                            }
                            // Si existeix la tasca a la base de dades
                            else {
                                // Mostrem les dades de la tasca
                                echo json_encode($tasca);
                            }
                        }
                        // Si l'usuari no té rol "gestor" o "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "obtenirTasques":
                    
                    break;
                case "obtenirTasquesAssignades":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this=>database->comprovarUsuarisToken($accessToken)[0];
                    if ($dadesUsuari == true) {
                        if ($dadesUsuari["rol"] == "tecnic" || $dadesUsuari["rol"] == "gestor" || $dadesUsuari["rol"] == "administrador") {
                            $tasques = $this->database->obtenirTasquesUsuari($dadesUsuari["usuariID"]);
                            echo json_encode($tasques);
                        }
                        else {
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    else {
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "crearTasca":
                    // Obtenim les dades JSON enviades a un endpoint de l'API
                    $data = json_encode(file_get_contents('php://input'));
                    $accesToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "administrador"
                        if ($rolUsuari["rol"] == "administrador") {
                            $tasca = array(
                                "nom"=>$data["nom"],
                                "descripcio"=>$data["descripcio"],
                                "data_alta"=>$data["data_alta"],
                                "data_inici"=>$data["data_inici"],
                                "data_fi"=>$data["data_fi"],
                                "prioritat"=>$data["prioritat"],
                                "estat"=>$data["estat"]
                            );
                            // Retornem true si s'ha creat la tasca
                            if ($tascaCreada) {
                                echo json_encode(true);
                            }
                            // Retornem false si no s'ha creat la tasca
                            else {
                                echo json_encode(false);
                            }
                        }
                        // Si l'usuari no té rol "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "actualitzarTasca":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "gestor" o "administrador"
                        if ($dadesUsuari["rol"] == "gestor" || $dadesUsuari["rol"] == "administrador") {
                            // Guardem en una variable un array amb totes les dades a canviar de la tasca
                            $tascaActualitzada = array(
                                "tascaID"=>$data["tascaID"],
                                "usuariID"=>$data["usuariID"],
                                "nom"=>$data["nom"],
                                "descripcio"=>$data["descripcio"],
                                "data_alta"=>$data["data_alta"],
                                "data_inici"=>$data["data_inici"],
                                "data_fi"=>$data["data_fi"],
                                "prioritat"=>$data["prioritat"],
                                "estat"=>$data["estat"]
                            );
                            // Cridem a la funció "actualitzarTasca" i guardem el resultat "true" o "false" en una variable
                            $resultat = $this->database->actualitzarTasca($tascaActualitzada);
                            // Mostrem "true" o "false" depenent de si s'ha modificat la tasca
                            echo json_encode($resultat);
                        }
                        // Si l'usuari no té rol "gestor" o "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "eliminarTasca":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "gestor" o "administrador"
                        if ($dadesUsuari["rol"] == "gestor" || $dadesUsuari["rol"] == "administrador") {
                            // Guardem l'ID de la tasca que volem eliminar en una variable
                            $tascaID = $data["tascaID"];
                            // Cridem a la funció "eliminarTasca" i guardem el resultat "true" o "false" en una variable
                            $resultat = $this->database->eliminarTasca($tascaID, $dadesUsuari["usuariID"]);
                            // Mostrem "true" o "false" depenent de si s'ha modificat la tasca
                            echo json_encode($resultat);
                        }
                        // Si l'usuari no té rol "gestor" o "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                /*=======
                 Usuaris
                ========*/
                // Obtenim les dades JSON enviades a un endpoint de l'API
                case "obtenirUsuari":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Guardem l'ID de l'usuari que volem obtenir a la variable
                    $usuariID = $data['usuariID'];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "administrador"
                        if ($rolUsuari["rol"] == "administrador") {
                            // Cridem a la funció "obtenirUsuari" passant-li l'ID de l'usuari
                            $usuari = $this->database->obtenirUsuari($usuariID);
                            // Si no existeix l'usuari a la base de dades
                            if ($usuari == null) {
                                // Retornem error 403
                                header('HTTP/1.1 403 Forbidden');
                            }
                            // Si existeix l'usuari a la base de dades
                            else {
                                // Mostrem les dades de l'usuari
                                echo json_encode($usuari);
                            }
                        }
                        // Si l'usuari no té rol "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "obtenirUsuaris":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "administrador"
                        if ($rolUsuari["rol"] == "administrador") {
                            // Cridem a la funció "obtenirUsuaris"
                            $usuaris = $this->database->obtenirUsuaris();
                            // Si no existeixen usuaris a la base de dades
                            if ($usuaris == null) {
                                // Retornem error 403
                                header('HTTP/1.1 403 Forbidden');
                            }
                            // Si existeixen usuaris a la base de dades
                            else {
                                // Mostrem les dades dels usuaris
                                echo json_encode($usuaris);
                            }
                        }
                        // Si l'usuari no té rol "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "obtenirUsuarisAssignats":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "administrador"
                        if ($rolUsuari["rol"] == "administrador") {
                            
                            // Cridem a la funció "" i guardem el resultat "true" o "false" en una variable
                            $resultat = $this->database->($usuariID);
                        }
                        // Si l'usuari no té rol "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "crearUsuari":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "administrador"
                        if ($rolUsuari["rol"] == "administrador") {
                            $nouUsuari = array(
                                "nom"=>$data["nom"],
                                "cognoms"=>$data["cognoms"],
                                "email"=>$data["email"],
                                "rol"=>$data["rol"],
                                "contrasenya"=>$data["contrasenya"]
                            );
                            // Cridem a la funció "crearUsuari" i guardem el resultat "true" o "false" en una variable
                            $resultat = $this->database->crearUsuari($nouUsuari);
                            // Si s'ha creat el nou usuari retornem true, false en cas contrari
                            if ($resultat) {
                                echo json_encode(true);
                            }
                            else {
                                echo json_encode(false);
                            }
                        }
                        // Si l'usuari no té rol "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                case "actualitzarUsuari":
                    $data = json_decode(file_get_contents('php://input'));
                    $accessToken = $data['accessToken'];
                    $dadesUsuari = $this->database->comprovarUsuarisToken($accessToken)[0];
                    // Si existeix un token
                    if ($dadesUsuari == true) {
                        // Si el rol de l'usuari és "administrador"
                        if ($rolUsuari["rol"] == "administrador") {
                            $usuariActualitzat = array(
                                "usuariID"=>$data["usuariID"],
                                "nom"=>$data["nom"],
                                "cognoms"=>$data["cognoms"],
                                "email"=>$data["email"],
                                "rol"=>$data["rol"],
                                "contrasenya"=>$data["contrasenya"]
                            );
                            // Cridem a la funció "modificarUsuari" i guardem el resultat "true" o "false" en una variable
                            $resultat = $this->database->actualitzarUsuari($usuariActualitzat);
                            // Si s'ha modificat l'usuari retornem true, false en cas contrari
                            if ($resultat) {
                                echo json_encode(true);
                            }
                            else {
                                echo json_encode(false);
                            }
                        }
                        // Si l'usuari no té rol "administrador"
                        else {
                            // Retornem error 403
                            header('HTTP/1.1 403 Forbidden');
                        }
                    }
                    // Si no existeix un token
                    else {
                        // Retornem error 403
                        header('HTTP/1.1 403 Forbidden');
                    }
                    break;
                // Si no s'ha trobat un endpoint
                default:
                    header('HTTP/1.1 404 Not Found');
                    break;
            }
        }
        // 
        private function ruta($url) {
            $uri = parse_url($url);
            return $uri['ruta'];
        }
    }

    // 
    $server = new Server($database);
    $server->serve();

    // Funció que genera un token hash
    /*function generarTokenHash($email, $token) {
        $usuariToken = hash("", $email.$token);
        return $usuariToken;
    }*/

    // Funció que genera un token nou aleatori
    function generarToken() {
        // El valor del token inicialment és buit
        $token = "";
        // La llargada máxima del token és de 16 caràcters
        $lenght = 16;
        // A la variable $caracters hi guardem valors numèrics i alfabètics
        $caracters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        // Fem un bucle que vagi assignant caràcters aleatoris al token fins arribar a la llargada màxima
        for ($i = 0; $i < $lenght; $i++) {
            $token += $caracters[random_int(0, $max - 1)];
        }
        return $token;
    }
?>