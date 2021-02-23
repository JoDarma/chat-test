import { Observable, BehaviorSubject, throwError, Subject } from 'rxjs';
import { map } from 'rxjs/operators';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { CustomResponse } from 'src/app/models/customResponse.model';
import { ConversationWithMessage } from '../models/conversation.model';


@Injectable({ providedIn: 'root' })

export class ConvService {

    conversationList : ConversationWithMessage[]=[]

    convMessage:any

    constructor(
    private router: Router,
    private http: HttpClient
    ) {}

     // Handle API errors
  handleError(error: HttpErrorResponse) {
    if (error.error instanceof ErrorEvent) {
      // A client-side or network error occurred. Handle it accordingly.
      console.error('An error occurred:', error.error.message);
    } else {
      // The backend returned an unsuccessful response code.
      // The response body may contain clues as to what went wrong,
      console.error(
        `Backend returned code ${error.status}, ` +
        `body was: ${error.error}`);
    }
    // return an observable with a Utilisateur-facing error message
    return throwError(
      'Something bad happened; please try again later.');
  }

  getConv(id:number){
    return this.http
    .get('/api/participation/'+id+'/list')
        .pipe(map(
        (resp:CustomResponse) => {
            this.conversationList = resp.response
            return this.conversationList
        }));
  }

  getConvMessage(idConv:number){
    return this.http
    .get('/api/conv/'+idConv)
        .pipe(map(
        (resp:CustomResponse) => {
            this.convMessage = resp.response
            console.log(resp)
            return this.convMessage
        }));
  }

  envoyerMess(message:string, id_utilisateur:number, id_conv:number){

    let data={
      "contenu":message,
      "id_utilisateur":id_utilisateur,
      "id_conversation":id_conv
    }
    return this.http.post('api/mess/creer', data)
      .pipe(map(
        (resp:CustomResponse) => {
            console.log(resp);
            this.convMessage[0].messages.push(resp.response)
            return this.convMessage
        }));
  }

  creerConv(participant:number[], type:string, userId){
    let data={
      "libelle":'',
      "type_conversation":type,
      "participants":participant
    }

    console.log(data)
  
    return this.http.post('api/conv/creer', data)
      .pipe(map(
        (resp:CustomResponse) => {
            console.log(resp);
            this.getConv(userId)
            return this.convMessage
        }));
  }
   
}