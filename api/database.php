<?php
    class database {
        public static $connection;

        // Funció que inicialitza la connexió amb la BDD
        public function connexioBDD($host, $user, $password, $database) {
            try {
                BdD::$connection = new PDO("mysql:host=$host;dbname=$database", $user, $password);
                BdD::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e) {
                echo "Connexió fallida: " . $e->getMessage();
            }
        }
        // Funció que comprova si existeix un usuari a la BDD que tingui el mateix correu i contrasenya
        public function comprovarUsuari($email, $contrasenya) {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM usuaris WHERE email = :email AND contrasenya = :contrasenya');
                $consulta->bindParam('email',$this->email);
                $consulta->bindParam('contrasenya',$this->contrasenya);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    foreach ($result as $fila) {
                        $usuariID = $fila["usuariID"];
                    }
                    $resposta = array("usuariID"=>$usuariID);
                    if ($resposta["usuariID"] == null) {
                        return false;
                    }
                    else {
                        return true;
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            return $resposta;
        }
        // Funció que comprova si existeix un token a la taula de tokens de la BDD
        public function comprovarTaulaToken($token) {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM tokens WHERE tokenValue = :token');
                $consulta = bindParam('token',$this->token);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    foreach($result as $fila) {
                        $tokenID = $fila["tokenID"];
                        $tokenValue = $fila["tokenValue"];
                    }
                    $resposta = array("tokenID"=>$tokenID, "tokenValue"=>$tokenValue);
                    if ($resposta["tokenID"] == null) {
                        return false;
                    }
                    else {
                        return true;
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
            }
            return $resposta;
        }
        // Funció que actualitza el valor del token d'un usuari
        public function actualitzarTokenUsuari($token, $email) {
            try {
                $consulta = (BdD::$connection)->prepare('UPDATE usuaris SET token = :token WHERE email = :email');
                $consulta->bindParam('token',$this->token);
                $consulta->bindParam('email',$this->email);
                // Fem la modificació a la BDD
                $qFiles = $consulta->execute();
                return true;
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
            }
        }
        // Funció que insereix un token a la taula de tokens de la BDD
        public function inserirToken($token) {
            try {
                $consulta = (BdD::$connection)->prepare('INSERT INTO tokens (tokenValue) VALUES (:token)');
                $consulta->bindParam('token',$this->token);
                // Fem la inserció a la BDD
                $qFiles = $consulta->execute();
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
        }
        // Funció que comprova si un token existeix en la taula d'usuaris de la BDD
        public function comprovarUsuarisToken($token) {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM usuaris WHERE token = :token');
                $consulta->bindParam('token',$this->token);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    $resposta = $result;
                    return $resposta;
                }
                else {
                    return false;
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
            }
            return $resposta;
        }
        // Funció que obté totes les tasques assignades a un usuari
        public function obtenirTasquesUsuari($usuariID) {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM tasques WHERE usuariID = :usuariID ORDER BY data_alta');
                $consulta->bindParam('usuariID',$this->usuariID);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    $resposta = $result;
                    if ($resposta == []) {
                        $resposta = "0";
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            return $resposta;
        }
        // Funció que obté les dades d'un usuari a la BDD
        public function obtenirUsuari($usuariID) {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM usuaris WHERE usuariID = :usuariID');
                $consulta->bindParam('usuariID',$this->usuariID);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    foreach ($result as $fila) {
                        $usuariID = $fila["usuariID"];
                        $nom = $fila["nom"];
                        $cognoms = $fila["cognoms"];
                        $email = $fila["email"];
                        $rol = $fila["rol"];
                        $contrasenya = $fila["contrasenya"];
                    }
                    $resposta = array("usuariID"=>$usuariID, "nom"=>$nom, "cognoms"=>$cognoms, "email"=>$email, "rol"=>$rol, "contrasenya"=>$contrasenya);
                    if ($resposta["email"] == null) {
                        return null;
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            return $resposta;
        }
        // Funció que obté les dades de tots els usuaris a la BDD
        public function obtenirUsuaris() {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM usuaris');
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    foreach ($result as $fila) {
                        $resposta[] = $fila;
                    }
                    if ($resposta == null) {
                        return "0";
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que obté tots els usuaris amb rol de "tecnic" de la BDD
        public function obtenirTecnics($rol) {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM usuaris WHERE rol = :rol');
                $consulta->bindParam('rol',$this->rol);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    foreach ($result as $fila) {
                        $resposta[] = $fila;
                    }
                    if ($resposta == null) {
                        return "0";
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que obté tots els usuaris amb rol de "gestor" de la BDD
        public function obtenirGestors($rol) {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM usuaris WHERE rol = :rol');
                $consulta->bindParam('rol',$this->rol);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    foreach ($result as $fila) {
                        $resposta[] = $fila;
                    }
                    if ($resposta == null) {
                        return "0";
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que obté tots els usuaris amb rol "administrador" de la BDD
        public function obtenirAdministradors() {
            $resposta = null;
            try {
                $consulta = (BdD::$connection)->prepare('SELECT * FROM usuaris WHERE rol = :rol');
                $consulta->bindParam('rol',$this->rol);
                $qFiles = $consulta->execute();

                if ($qFiles > 0) {
                    $consulta->setFetchMode(PDO::FETCH_ASSOC);
                    $result = $consulta->fetchAll();
                    foreach ($result as $fila) {
                        $resposta[] = $fila;
                    }
                    if ($resposta == null) {
                        return "0";
                    }
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que crea un usuari a la BDD
        public function crearUsuari() {
            $resposta= true;
            try {
                $consulta = (BdD::$connection)->prepare('INSERT INTO usuaris (usuariID, nom, cognoms, email, rol, contrasenya) VALUES (:usuariID, :nom, :cognoms, :email, :rol, :contrasenya)');
                $consulta->bindParam('usuariID',$this->usuariID);
                $consulta->bindParam('nom',$this->nom);
                $consulta->bindParam('cognoms',$this->cognoms);
                $consulta->bindParam('email',$this->email);
                $consulta->bindParam('rol',$this->rol);
                $consulta->bindParam('contrasenya',$this->contrasenya);
                $qFiles = $consulta->execute();
                // Comprovem si s'ha modificat alguna línia en la taula d'usuaris
                if ($consulta->rowCount() == 0) {
                    $resposta = false;
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que actualitza un usuari a la BDD
        public function actualitzarUsuari($usuariActualitzat) {
            $resposta = true;
            try {
                $consulta = (BdD::$connection)->prepare('UPDATE usuaris SET usuariID = :usuariID, nom =:nom, cognoms = :cognoms, email = :email, rol = :rol, contrasenya = :contrasenya WHERE usuariID = :usuariID');
                $consulta->bindParam('usuariID',$usuariActualitzat["usuariID"]);
                $consulta->bindParam('nom',$usuariActualitzat["nom"]);
                $consulta->bindParam('cognoms',$usuariActualitzat["cognoms"]);
                $consulta->bindParam('email',$usuariActualitzat["email"]);
                $consulta->bindParam('rol',$usuariActualitzat["rol"]);
                $consulta->bindParam('contrasenya',$usuariActualitzat["contrasenya"]);
                $qFiles = $consulta->execute();
                // Comprovem si s'ha modificat alguna línia en la taula d'usuaris
                if ($consulta->rowCount() == 0) {
                    $resposta = false;
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que crea una tasca a la BDD
        public function crearTasca() {
            $resposta= true;
            try {
                $consulta = (BdD::$connection)->prepare('INSERT INTO tasques (tascaID, usuariID, nom, descripcio, data_alta, data_inici, data_fi, prioritat, estat, comentari) VALUES (:tascaID, :usuariID, :nom, :descripcio, :data_alta, :data_inici, :data_fi, :prioritat, :estat, :comentari)');
                $consulta->bindParam('tascaID',$this->tascaID);
                $consulta->bindParam('usuariID',$this->usuariID);
                $consulta->bindParam('nom',$this->nom);
                $consulta->bindParam('descripcio',$this->descripcio);
                $consulta->bindParam('data_alta',$this->data_alta);
                $consulta->bindParam('data_inici',$this->data_inici);
                $consulta->bindParam('data_fi',$this->data_fi);
                $consulta->bindParam('prioritat',$this->prioritat);
                $consulta->bindParam('estat',$this->estat);
                $consulta->bindParam('comentari',$this->comentari);
                $qFiles = $consulta->execute();
                // Comprovem si s'ha modificat alguna línia en la taula de tasques
                if ($consulta->rowCount() == 0) {
                    $resposta = false;
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que actualitza una tasca a la BDD
        public function actualitzarTasca($tascaModificada) {
            $resposta = true;
            try {
                $consulta = (BdD::$connection)->prepare('UPDATE tasques SET tascaID = :tascaID, usuariID =:usuariID, nom = :nom, descripcio = :descripcio, data_alta = :data_alta, data_inici = :data_Inici, data_fi = :data_fi, prioritat = :prioritat, estat = :estat, comentari = :comentari WHERE tascaID = :tascaID');
                $consulta->bindParam('tascaID',$this->tascaID);
                $consulta->bindParam('usuariID',$this->usuariID);
                $consulta->bindParam('nom',$this->nom);
                $consulta->bindParam('descripcio',$this->descripcio);
                $consulta->bindParam('data_alta',$this->data_alta);
                $consulta->bindParam('data_inici',$this->data_inici);
                $consulta->bindParam('data_fi',$this->data_fi);
                $consulta->bindParam('prioritat',$this->prioritat);
                $consulta->bindParam('estat',$this->estat);
                $consulta->bindParam('comentari',$this->comentari);
                $qFiles = $consulta->execute();
                // Comprovem si s'ha modificat alguna línia en la taula de tasques
                if ($consulta->rowCount() == 0) {
                    $resposta = false;
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
        // Funció que elimina una tasca a la BDD
        public function eliminarTasca($tascaID, $usuariID) {
            $resposta= true;
            try {
                $consulta = (BdD::$connection)->prepare('DELETE FROM tasques WHERE tascaID = :tascaID AND usuariID = :usuariID');
                $consulta->bindParam('tascaID',$tascaID);
                $consulta->bindParam('usuariID',$usuariID);
                $qFiles = $consulta->execute();
                $this->tascaID = null;
                // Comprovem si s'ha modificat alguna línia en la taula de tasques
                if ($consulta->rowCount() == 0) {
                    $resposta = false;
                }
            }
            catch(PDOException $e) {
                echo "Error: " .$e->getMessage();
                $resposta = false;
            }
            return $resposta;
        }
    }

    $db = new database();
    // Connexió amb la base de dades
    $db->connect("127.0.0.1", "adminer", "Taskio2023", "taskio");
?>