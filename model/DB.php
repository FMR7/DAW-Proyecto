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

    
    function getLikes($idReceta){
        try{
            $queryLikes = "select COUNT(meGusta) as likes from opiniones WHERE idReceta=:idReceta AND meGusta=1";
            $stmt = $this->prepare($queryLikes);
            $stmt->bindParam(':idReceta', $idReceta);
            $stmt->execute();

            $likes = $stmt->fetchAll();
            
            
            $queryDislikes = "select COUNT(meGusta) as disLikes from opiniones WHERE idReceta=:idReceta AND meGusta=0";
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
            $query = "SELECT r.* FROM recetas r JOIN usuario_recetas ur ON r.idReceta=ur.idReceta JOIN usuarios u ON ur.username=u.username WHERE u.username=:username";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':username', $user);
            $stmt->execute();

            return $stmt->fetchAll();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    
    
    /**
    * Inserta una receta
    * Si se ha insertado correctamente la asocia con el usuario sino se elimina
    */
    public function setReceta($nombre, $elabo, $ingre, $diff, $tIngre, $numCom){
        try{
            $query = "INSERT INTO `recetas`(`idReceta`, `nombre`, `ingredientes`, `elaboracion`, `dificultad`, `tipoIngredientes`, `numComensales`) VALUES(NULL, :nombre, :ingre, :elabo, :diff, :tipoIngre, :numCom)";
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
    
    
    function lastInsertedId(){
        try{
            $stmt = $this->query("SELECT LAST_INSERT_ID()");
            $idReceta = $stmt->fetchAll();
            
            return $idReceta[0][0];
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    
    //Asocia tipos de receta a una receta
    function setRecetaTipos($idReceta, $tipos){
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
    function setRecetaUser($user, $idReceta){
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
    //Insertar receta FIN

    
    //Borra una receta
    public function delReceta($user, $idReceta){
        try{
            $query = "DELETE FROM recetas WHERE idReceta=:idReceta";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':idReceta', $idReceta);

            $deleted = $stmt->execute();
            if($deleted){
                return delRecetaUser($user, $idReceta);
            }
            return $deleted;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    //Borra la asociación de la receta con el usuario
    function delRecetaUser($user, $idReceta){
        try{
            $query = "DELETE FROM usuario_recetas WHERE username=:user AND idReceta=:idReceta)";
            $stmt = $this->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':idReceta', $idReceta);
            
            return $stmt->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    

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

}
?>