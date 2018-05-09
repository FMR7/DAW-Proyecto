<?php
class DB extends PDO {
    public static $con;

    public function __construct(){
        try{
            //parent::__construct('mysql:host=' . Config::$mvc_bd_hostname . ';dbname=' . Config::$mvc_bd_nombre . '', Config::$mvc_bd_usuario, Config::$mvc_bd_clave );
            parent::__construct('mysql:host=localhost;dbname=recetas', "root", "");
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            parent::exec("set names utf8");
        } catch(PDOException $e){
            echo "<p>Error: No puede conectarse con la base de datos.</p>\n";
            echo "<p>Error: " . $e->getMessage();
        }
    }


    public static function GetInstance(){
        if(self::$con==null){
            self::$con=new self();
        }

        return self::$con;
    }


    public function getRecetas(){        
        try {
            $query = "select r.idReceta, r.nombre, d.dificultad, ti.tipoIngrediente, r.numComensales from recetas r JOIN tipoIngredientes ti ON r.tipoIngredientes=ti.idTipoIngrediente JOIN tipodificultades d ON r.dificultad=d.idDificultad";
            $stmt = $this->query($query);
            return $stmt->fetchAll();
        } catch(PDOException $e){
            echo "<p>Error: " . $e->getMessage();
        }
    }
    
    
    public function getReceta($idReceta){
        try{
            $query = "select r.nombre, r.elaboracion, r.ingredientes, d.dificultad, ti.tipoIngrediente, r.numComensales from recetas r JOIN tipoIngredientes ti ON r.tipoIngredientes=ti.idTipoIngrediente JOIN tipodificultades d ON r.dificultad=d.idDificultad WHERE r.idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    
    public function getTiposReceta($idReceta){
        try{
            $query = "SELECT r.idReceta, tr.tipo FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.idReceta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE r.idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    //BUSQUEDAS SIMPLES Y COMBINADAS
    //ESTA POR VER
    public function getRecetasDif($dificultad){
        try{
            $query = "SELECT * FROM recetas WHERE dificultad=:dificultad";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':dificultad', $dificultad);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasNumCom($numComensales){
        try{
            $query = "SELECT * FROM recetas WHERE numComensales=:numComensales";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':numComensales', $numComensales);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasTipo($tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.idReceta, r.nombre FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.idReceta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in GROUP BY r.idReceta";
            $stmt = $this->query($query);
            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasDifNumCom($dificultad, $numComensales){
        try{
            $query = "SELECT * FROM recetas WHERE dificultad=:dificultad AND numComensales>=:numComensales";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':dificultad', $dificultad);
            $stmt->bindParam(':numComensales', $numComensales);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasDifTipo($dificultad, $tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.* FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.receta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in AND dificultad=:dificultad GROUP BY r.idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':dificultad', $dificultad);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasNumComTipo($numComensales, $tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.* FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.receta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in AND numComensales=:numComensales GROUP BY r.idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':numComensales', $numComensales);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasDifNumComTipo($dificultad, $numComensales, $tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.* FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.receta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in AND dificultad=:dificultad AND numComensales=:numComensales GROUP BY r.idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':dificultad', $dificultad);
            $stmt->bindParam(':numComensales', $numComensales);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //ESTA POR VER FIN

    
    //Devuelve las opiniones de una receta
    public function getOpinionesRecetas($idReceta){
        try{
            $query = "SELECT o.username, o.comentario FROM opiniones o JOIN recetas r ON o.idReceta=r.idReceta WHERE r.idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    
    //Devuelve las recetas de un usuario
    public function getRecetasUser($user){
        try{
            $query = "select r.idReceta, r.nombre, d.dificultad, ti.tipoIngrediente, r.numComensales from recetas r JOIN tipoIngredientes ti ON r.tipoIngredientes=ti.idTipoIngrediente JOIN tipodificultades d ON r.dificultad=d.idDificultad JOIN usuario_recetas ur ON r.idReceta=ur.idReceta JOIN usuarios u ON ur.username=u.username WHERE u.username=:username";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':username', $user);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    
    //RECETA
    public function setLike($idReceta, $user, $like){
        try{
            $query = "INSERT INTO opiniones(idReceta, username, meGusta) VALUES(:idReceta, :user, :meGusta) ON DUPLICATE KEY UPDATE meGusta=:meGusta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':meGusta', $like);
            
            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function getLike($idReceta, $user){
        try{
            $query = "SELECT meGusta FROM opiniones WHERE idReceta=:idReceta AND username=:user";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->bindParam(':user', $user);
            $stmt->execute();
            $rs = $stmt->fetchAll();
            
            if(count($rs)==1){
                return $rs[0][0];
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function setComment($idReceta, $user, $comment){
        try{
            $query = "INSERT INTO opiniones(idReceta, username, comentario) VALUES(:idReceta, :user, :comment) ON DUPLICATE KEY UPDATE comentario=:comment";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':comment', $comment);
            
            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function getLikes($idReceta){
        try{
            $queryLikes = "select COUNT(meGusta) as likes from opiniones WHERE idReceta=:idReceta AND meGusta=2";
            $stmt = $this->prepare($queryLikes);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();

            $likes = $stmt->fetchAll();
            
            
            $queryDislikes = "select COUNT(meGusta) as disLikes from opiniones WHERE idReceta=:idReceta AND meGusta=1";
            $stmt = $this->prepare($queryDislikes);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();

            $disLikes = $stmt->fetchAll();
            
            
            $total = ['likes'=>$likes[0][0], 'disLikes'=>$disLikes[0][0]];
            return $total;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function getComments($idReceta){
        try{
            $query = "SELECT username, comentario FROM opiniones WHERE idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();
            $rs = $stmt->fetchAll();
            
            
            return $rs;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //RECETA FIN
    
    
    //INSERTAR RECETA
    public function setReceta($nombre, $elabo, $ingre, $diff, $tIngre, $numCom){
        try{
            $query = "INSERT INTO recetas (idReceta, nombre, ingredientes, elaboracion, dificultad, tipoIngredientes, numComensales) VALUES(NULL, :nombre, :ingre, :elabo, :diff, :tipoIngre, :numCom)";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':elabo', $elabo);
            $stmt->bindParam(':ingre', $ingre);
            $stmt->bindParam(':diff', $diff);
            $stmt->bindParam(':tipoIngre', $tIngre);
            $stmt->bindParam(':numCom', $numCom);
            
            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    //Devuelve el último ID insertado
    public function lastInsertedId(){
        try{
            $stmt = $this->query("SELECT LAST_INSERT_ID()");
            $idReceta = $stmt->fetchAll();
            
            return $idReceta[0][0];
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    //Asocia tipos de receta a una receta
    public function setRecetaTipos($idReceta, $tipos){
        $tipos = explode('#', $tipos);
        foreach($tipos as $tipo){
            try{
                $query = "INSERT INTO recetas_tipos(idReceta, idTipo) VALUES(:idReceta, :tipo)";
                $stmt = $this->prepare($query);
                $stmt->bindParam(':idReceta', $idReceta);
                $stmt->bindParam(':tipo', $tipo);

                $stmt->execute();
            }catch(PDOException $e){
                echo "<p>Error: ".$e->getMessage();
            }
        }
    }
    
    //Asocia una receta con un usuario
    public function setRecetaUser($user, $idReceta){
        try{
            $query = "INSERT INTO usuario_recetas(username, idReceta) VALUES(:user, :idReceta)";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':idReceta', $idReceta);
            
            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //INSERTAR RECETA FIN

    
    
    //ACTUALIZAR RECETA
    public function updateReceta($idReceta, $nombre, $elabo, $ingre, $diff, $tIngre, $numCom){
        try{
            $query = "UPDATE recetas SET nombre=:nombre, elaboracion=:elabo, ingredientes=:ingre, dificultad=:diff, tipoIngredientes=:tipoIngre, numComensales=:numCom WHERE idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':elabo', $elabo);
            $stmt->bindParam(':ingre', $ingre);
            $stmt->bindParam(':diff', $diff);
            $stmt->bindParam(':tipoIngre', $tIngre);
            $stmt->bindParam(':numCom', $numCom);
            

            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //ACTUALIZAR RECETA FIN
    
    
    
    //BORRAR RECETA
    public function delReceta($idReceta){
        try{
            $query = "DELETE FROM recetas WHERE idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);

            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    //Borra la asociación de la receta con sus tipos
    public function delRecetaTipos($idReceta){
        try{
            $query = "DELETE FROM recetas_tipos WHERE idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);

            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //BORRAR RECETA FIN

    
    
    //INICIO
    public function getTipoDificultades(){
        try{
            $query = "SELECT * FROM tipodificultades";
            $stmt = $this->query($query);
            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    public function getTipoIngredientes(){
        try{
            $query = "SELECT * FROM tipoingredientes";
            $stmt = $this->query($query);
            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    public function getTipoReceta(){
        try{
            $query = "SELECT * FROM tiporeceta";
            $stmt = $this->query($query);
            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //INICIO FIN
    
    
    
    //PERFIL
    public function getProfile($user){
        try{
            $query = "SELECT username, email, emailConfirmed FROM usuarios WHERE username=:user";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->execute();
            
	        $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return $rs[0];
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function getPass($user){
        try{
            $query = "SELECT password FROM usuarios WHERE username=:user";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->execute();
            
	        $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return $rs[0][0];
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function setPass($user, $pass){
        try{
            $query = "UPDATE usuarios SET password = :pass WHERE username=:user";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':pass', $pass);
            $stmt->execute();
            
	        return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function getFavs($user){
        try{
            $query = "select r.idReceta, r.nombre, d.dificultad, ti.tipoIngrediente, r.numComensales from recetas r JOIN tipoIngredientes ti ON r.tipoIngredientes=ti.idTipoIngrediente JOIN tipodificultades d ON r.dificultad=d.idDificultad JOIN opiniones o ON o.idReceta=r.idReceta WHERE o.meGusta=2 AND o.username=:username";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':username', $user);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //PERFIL FIN
    
    
    
    //LOGIN
    public function getUser($user, $pass){
        try{
            $query = "SELECT * FROM usuarios WHERE username=:user AND password=:pass";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':pass', $pass);
            $stmt->execute();
            
	        $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return true;
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //LOGIN FIN
    
    
    
    
    //REGISTER
    public function setUser($user, $email, $pass){
        try{
            $query = "INSERT  INTO `usuarios` (`username`, `password`, `email`, `emailConfirmed`) VALUES (:user, :pass, :email, '0')";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':email', $email);

            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //REGISTER FIN

    
    //CONFIRMAR EMAIL
    public function setTokenEmail($user, $token){
        try{
            $query = "INSERT INTO confirmemail (username, tokenEmail) VALUES (:user, :token)";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':token', $token);

            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function activarCuenta($username){
        try{
            $query = "UPDATE usuarios SET emailConfirmed=1 WHERE username=:username";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':username', $username);

            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function getUserFromToken($token){
        try{
            $query = "SELECT u.username FROM usuarios u JOIN confirmEmail ce ON u.username=ce.username WHERE ce.tokenEmail=:token";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            
            $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return $rs;
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //CONFIRMAR EMAIL FIN
    
    public function existsReceta($idReceta){
        try{
            $query = "SELECT nombre FROM recetas WHERE idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();
            
	        $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return true;
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function existsUser($user){
        try{
            $query = "SELECT username FROM usuarios WHERE username=:user";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->execute();
            
	        $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return true;
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    public function existsEmail($email){
        try{
            $query = "SELECT email FROM usuarios WHERE email=:email";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
	        $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return true;
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    //Devuelve si la receta es del usuario
    public function isFromUser($idReceta, $user){
        try{
            $query = "SELECT ur.username, r.* FROM recetas r JOIN usuario_recetas ur ON ur.idReceta=r.idReceta WHERE ur.username=:user and ur.idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();
            
	        $rs = $stmt->fetchAll();
            if(count($rs)==1){
                return true;
            }
            return false;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
}
?>