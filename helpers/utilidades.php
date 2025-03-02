<?php

class Utils {
  public static function eliminarSession($nombre) {
    if (isset($_SESSION[$nombre])) {
      $_SESSION[$nombre] = null;
      unset($_SESSION[$nombre]);
    }

    return $nombre;
  }

  public static function esAdmin() {
    if (!isset($_SESSION['admin'])) {
      header('Location:' . URL_BASE);
    } else {
      return true;
    }
  }

  public static function login() {
    if (!isset($_SESSION['identidad'])) {
      header('Location:' . URL_BASE);
    } else {
      return true;
    }
  }

  public static function mostrarCategorias() {
    require_once 'models/categoria.php';
      
    $categoria = new Categoria();
    $categorias = $categoria->obtenerTodo();

    return $categorias;
  }

  public static function estadisticaCarrito() {
    $estadistica = array(
    'cont' => 0,
    'total' => 0
    );

    if (isset($_SESSION['carrito'])) {
      $estadistica['cont'] = count($_SESSION['carrito']);

      foreach ($_SESSION['carrito'] as $valor) {
        $producto = $valor['producto']; // Obtener el objeto producto
        $estadistica['total'] += $producto->precio * $valor['unidades']; // Sumar el total
      }
    }

    return $estadistica;
  }

  public static function mostrarEstado($estado)  {
    $valor = 'Pendiente';
    
    switch ($estado) {
      case 'confirmado':
        $valor = 'Pendiente';
        break;
      case 'preparacion':
        $valor = 'En preparación';
        break;
      case 'listo':
        $valor = 'Preparado para enviar';
        break;
      case 'enviado':
        $valor = 'Enviado';
        break;
    }

    return $valor;
  }
  
}

?>