<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @SWG\Swagger(
     *      basePath="/v1",
    * 		host="api.local",
    * 		schemes={"http"},
    * 		produces={"application/json"},
    * 		consumes={"application/json"},
     *      @SWG\Info(
     *          version="1.0.0",
     *          title="L5 Swagger API",
     *          description="L5 Swagger API description",
     *          @SWG\Contact(
     *              email="darius@matulionis.lt"
     *          ),
     *      ),
     *      @SWG\Definition(
 *              definition="Staff",
 *              type="object",
 *              @SWG\Property(
 *                  property="id",
 *                  type="integer",
 *                  description="ID staff",
 *              ),
 *              @SWG\Property(
 *                  property="email",
 *                  type="string",
 *                  description="Email staff",
 *              ),
 *              @SWG\Property(
 *                  property="password",
 *                  type="string",
 *                  description="Password staff",
 *              ),
 *          ),
 *          @SWG\Definition(
 *              definition="Project",
 *              type="object",
   *             @SWG\Property(property="1", type="object",
     *                      ref="#/definitions/Staff"
     *                  ),
 *              @SWG\Property(
 *                  description="name project",
 *                  property="name",
 *                  type="string"
 *              ),
 * 
 *              @SWG\Property(property="user", type="object",
 *                      type="array",
 *                      @SWG\Items(ref="#/definitions/Staff"),
 *                  ),
 *          ),
 *         
    
     *  )
     */

    /**
     * @SWG\Get(
     *     path="/api/user",
     *     description="Return a user's first and last name",
    *       @SWG\Response(
    *           response=200,
    *           description="",
    *           @SWG\Schema(ref="#/definitions/Staff"),
    * ),
    *
     *     @SWG\Response(
     *         response=422,
     *         description="104 : Invalid Token",
     *     )
     * )
     */
    /**
     * @SWG\Get(
     *     path="/api/project",
     *     description="Return a user's first and last name",
    *       @SWG\Response(
    *           response=200,
    *           description="",
    *           @SWG\Schema(ref="#/definitions/Project"),
    * ),
    *
     *     @SWG\Response(
     *         response=422,
     *         description="104 : Invalid Token",
     *     )
     * )
     */
    public function create(Request $request)
    {
        $userData = $request->only([
            'firstname',
            'lastname',
            'birthday'
        ]);
        if(!preg_match('/^\d{3}-\d{2}-\d{4}$/', $userData['birthday'])){
            return \response()->json(('Missing data birthday'), 422);
        }
        if (empty($userData['firstname']) && empty($userData['lastname'])) {
            return \response()->json(('Missing data'), 422);
        }
        return \response()->json($userData['firstname'] . ' ' . $userData['lastname'], 200);
    }
}
