<?php
class DB extends PDO {
    public static $con;

    public function __construct(){
        try{
            //parent::__construct('mysql:host=' . Config::$mvc_bd_hostname . ';dbname=' . Config::$mvc_bd_nombre . '', Config::$mvc_bd_usuario, Config::$mvc_bd_clave );
            parent::__construct('mysql:host=localhost;dbname=recetas', "root", "");
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            parent::exec("set names utf8");
        } catch ( PDOException $e ) {
            echo "<p>Error: No puede conectarse con la base de datos.</p>\n";
            echo "<p>Error: " . $e->getMessage ();
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
            $stmt = $this->query ( $query );
            return $stmt->fetchAll ();
        } catch ( PDOException $e ) {
            echo "<p>Error: " . $e->getMessage ();
        }
    }


    public function getReceta($idReceta){
        try{
            //$query = "SELECT * FROM recetas WHERE idReceta=:idReceta";
            $query = "select r.nombre, r.elaboracion, r.ingredientes, d.dificultad, ti.tipoIngrediente, r.numComensales from recetas r JOIN tipoIngredientes ti ON r.tipoIngredientes=ti.idTipoIngrediente JOIN tipodificultades d ON r.dificultad=d.idDificultad WHERE r.idReceta=:idReceta";
            $rs = $this->prepare($query);
            $rs->bindParam(':idReceta', $idReceta);
            $rs->execute();

            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    
    function getLikes($idReceta){
        try{
            $query = "select COUNT(meGusta) as likes from opiniones WHERE idReceta=:idReceta AND meGusta=1";
            $rs = $this->prepare($query);
            $rs->bindParam(':idReceta', $idReceta);
            $rs->execute();

            $likes = $rs->fetchAll ();
            
            
            $query2 = "select COUNT(meGusta) as disLikes from opiniones WHERE idReceta=:idReceta AND meGusta=0";
            $rs = $this->prepare($query2);
            $rs->bindParam(':idReceta', $idReceta);
            $rs->execute();

            $disLikes = $rs->fetchAll ();
            
            
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
            $rs = $this->prepare($query);
            $rs->bindParam(':dificultad', $dificultad);
            $rs->execute();

            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasNumCom($numComensales){
        try{
            $query = "SELECT * FROM recetas WHERE numComensales=:numComensales";
            $rs = $this->prepare($query);
            $rs->bindParam(':numComensales', $numComensales);
            $rs->execute();

            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasTipo($tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.idReceta, r.nombre FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.idReceta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in GROUP BY r.idReceta";
            $stmt = $this->query ( $query );
            return $stmt->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasDifNumCom($dificultad, $numComensales){
        try{
            $query = "SELECT * FROM recetas WHERE dificultad=:dificultad AND numComensales>=:numComensales";
            $rs = $this->prepare($query);
            $rs->bindParam(':dificultad', $dificultad);
            $rs->bindParam(':numComensales', $numComensales);
            $rs->execute();

            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasDifTipo($dificultad, $tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.* FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.receta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in AND dificultad=:dificultad GROUP BY r.idReceta";
            $rs = $this->prepare($query);
            $rs->bindParam(':dificultad', $dificultad);
            $rs->execute();
            return $stmt->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasNumComTipo($numComensales, $tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.* FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.receta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in AND numComensales=:numComensales GROUP BY r.idReceta";
            $rs = $this->prepare($query);
            $rs->bindParam(':numComensales', $numComensales);
            $rs->execute();
            return $stmt->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }


    public function getRecetasDifNumComTipo($dificultad, $numComensales, $tipo){
        $in = '('.implode(',', $tipo).')';
        try{
            $query = "SELECT r.* FROM recetas r JOIN recetas_tipos rt ON r.idReceta=rt.receta JOIN tiporeceta tr ON tr.idTipo=rt.idTipo WHERE tr.idTipo IN $in AND dificultad=:dificultad AND numComensales=:numComensales GROUP BY r.idReceta";
            $rs = $this->prepare($query);
            $rs->bindParam(':dificultad', $dificultad);
            $rs->bindParam(':numComensales', $numComensales);
            $rs->execute();
            return $stmt->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //ESTA POR VER FIN

    
    //Devuelve las opiniones de una receta
    public function getOpinionesRecetas($idReceta){
        try{
            $query = "SELECT o.username, o.comentario FROM opiniones o JOIN recetas r ON o.idReceta=r.idReceta WHERE r.idReceta=:idReceta";
            $rs = $this->prepare($query);
            $rs->bindParam(':idReceta', $idReceta);
            $rs->execute();

            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    
    public function getUser($user, $pass){
        try{
            $query = "SELECT * FROM usuarios WHERE username=:username and password=:password";
            $rs = $this->prepare($query);
            $rs->bindParam(':username', $user);
            $rs->bindParam(':password', $pass);
            $rs->execute();

            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    //Devuelve las recetas de un usuario
    public function getRecetasUser($user){
        try{
            $query = "SELECT r.* FROM recetas r JOIN usuario_recetas ur ON r.idReceta=ur.idReceta JOIN usuarios u ON ur.username=u.username WHERE u.username=:username";
            $rs = $this->prepare($query);
            $rs->bindParam(':username', $user);
            $rs->execute();

            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    
    
    /**
    * Inserta una receta
    * Si se ha insertado correctamente la asocia con el usuario sino se elimina
    */
    public function setReceta($user, $nombre, $ingredientes, $elaboracion, $dificultad, $numComensales){
        try{
            $query = "INSERT INTO `recetas` (`idReceta`, `nombre`, `ingredientes`, `elaboracion`, `dificultad`, `numComensales`) VALUES (NULL, :nombre, :ingredientes, :elaboracion, :dificultad, :numComensales)";
            $rs = $this->prepare($query);
            $rs->bindParam(':nombre', $nombre);
            $rs->bindParam(':ingredientes', $ingredientes);
            $rs->bindParam(':elaboracion', $elaboracion);
            $rs->bindParam(':dificultad', $dificultad);
            $rs->bindParam(':numComensales', $numComensales);
            
            $inserted = $rs->execute();
            $lastId = "SELECT LAST_INSERT_ID()";
            if($inserted){
                $stmt = $this->query($lastId);
                $idReceta = $stmt->fetchAll ();
                
                return setRecetaUser($user, $idReceta);
            }else{
                delReceta($lastId);
            }
            return $inserted;
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }

    //Asocia una receta con un usuario
    function setRecetaUser($user, $idReceta){
        try{
            $query = "INSERT INTO usuario_recetas (username, idReceta) VALUES (:user, :idReceta)";
            $rs = $this->prepare($query);
            $rs->bindParam(':user', $user);
            $rs->bindParam(':idReceta', $idReceta);
            
            return $rs->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    //Insertar receta FIN

    
    //Borra una receta
    public function delReceta($user, $idReceta){
        try{
            $query = "DELETE FROM recetas WHERE idReceta=:idReceta";
            $rs = $this->prepare($query);
            $rs->bindParam(':idReceta', $idReceta);

            $deleted = $rs->execute();
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
            $rs = $this->prepare($query);
            $rs->bindParam(':user', $user);
            $rs->bindParam(':idReceta', $idReceta);
            
            return $rs->execute();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    

    //INICIO
    public function getTipoDificultades(){
        try{
            $query = "SELECT * FROM tipodificultades";
            $rs = $this->query ( $query );
            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    public function getTipoIngredientes(){
        try{
            $query = "SELECT * FROM tipoingredientes";
            $rs = $this->query ( $query );
            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    public function getTipoReceta(){
        try{
            $query = "SELECT * FROM tiporeceta";
            $rs = $this->query ( $query );
            return $rs->fetchAll ();
        }catch(PDOException $e){
            echo "<p>Error: ".$e->getMessage();
        }
    }
    
    //INICIO FIN


}
?>