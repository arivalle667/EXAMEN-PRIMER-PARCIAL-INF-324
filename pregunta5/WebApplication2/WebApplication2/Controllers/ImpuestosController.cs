using Microsoft.AspNetCore.Mvc;

namespace ImpuestosAPI.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class ImpuestosController : ControllerBase
    {
        [HttpGet]
        public IActionResult GetTipoImpuesto(string codigo_catastral)
        {
            if (string.IsNullOrEmpty(codigo_catastral))
            {
                return BadRequest("El código catastral no puede estar vacío.");
            }

            // Obtener el primer dígito del código catastral
            char prefijo = codigo_catastral[0];
            string tipoImpuesto;

            // Determinar el tipo de impuesto basado en el prefijo
            switch (prefijo)
            {
                case '1':
                    tipoImpuesto = "Alto";
                    break;
                case '2':
                    tipoImpuesto = "Medio";
                    break;
                case '3':
                    tipoImpuesto = "Bajo";
                    break;
                default:
                    tipoImpuesto = "Desconocido";
                    break;
            }

            // Devolver el tipo de impuesto como respuesta
            return Ok(tipoImpuesto);
        }
    }
}
