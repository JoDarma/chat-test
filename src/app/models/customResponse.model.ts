export class CustomResponse{
    constructor(
        public success:boolean,
        public status : number,
        public response:any,
    ){}
}