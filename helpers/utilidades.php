<?php

// Define la clase Utils, que contiene métodos estáticos para utilidades generales.
class Utils {
  // Método para eliminar una variable de sesión específica.
  public static function eliminarSession($nombre) {
    // Verifica si la variable de sesión existe.
    if (isset($_SESSION[$nombre])) {
      $_SESSION[$nombre] = null; // Establece la variable de sesión como null.
      unset($_SESSION[$nombre]); // Elimina la variable de sesión.
    }

    return $nombre; // Retorna el nombre de la variable de sesión eliminada.
  }

  // Método para verificar si el usuario actual es un administrador.
  public static function esAdmin() {
    // Verifica si la sesión de administrador no está establecida.
    if (!isset($_SESSION['admin'])) {
      header('Location:' . URL_BASE); // Redirige a la página principal si no es administrador.
    } else {
      return true; // Retorna true si el usuario es administrador.
    }
  }

  // Método para verificar si el usuario ha iniciado sesión.
  public static function login() {
    // Verifica si la sesión de identidad no está establecida.
    if (!isset($_SESSION['identidad'])) {
      header('Location:' . URL_BASE); // Redirige a la página principal si no ha iniciado sesión.
    } else {
      return true; // Retorna true si el usuario ha iniciado sesión.
    }
  }

  // Método para obtener y mostrar todas las categorías.
  public static function mostrarCategorias() {
    // Incluye el archivo del modelo Categoria.
    require_once 'models/categoria.php';

    // Crea una instancia del modelo Categoria.
    $categoria = new Categoria();
    // Obtiene todas las categorías de la base de datos.
    $categorias = $categoria->obtenerTodo();

    return $categorias; // Retorna la lista de categorías.
  }

  // Método para calcular estadísticas del carrito de compras.
  public static function estadisticaCarrito() {
    // Inicializa un array con las estadísticas del carrito.
    $estadistica = array(
    'cont' => 0, // Cantidad de productos en el carrito.
    'total' => 0 // Coste total del carrito.
    );

    // Verifica si el carrito existe en la sesión.
    if (isset($_SESSION['carrito'])) {
      // Cuenta la cantidad de productos en el carrito.
      $estadistica['cont'] = count($_SESSION['carrito']);

      // Recorre los productos en el carrito para calcular el coste total.
      foreach ($_SESSION['carrito'] as $valor) {
        $producto = $valor['producto']; // Obtiene el objeto producto.
        $estadistica['total'] += $producto->precio * $valor['unidades']; // Suma el total.
      }
    }

    return $estadistica; // Retorna las estadísticas del carrito.
  }

  // Método para mostrar el estado de un pedido en formato legible.
  public static function mostrarEstado($estado)  {
    $valor = 'Pendiente'; // Valor por defecto.

    // Asigna un texto descriptivo según el estado del pedido.
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

    return $valor; // Retorna el estado en formato legible.
  }

}

?>