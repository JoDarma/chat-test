import { Observable, BehaviorSubject, throwError, Subject } from 'rxjs';
import { map } from 'rxjs/operators';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Utilisateur } from '../models/utilisateur.model';
import { CustomResponse } from '../models/customResponse.model';
import { ConversationWithMessage } from '../models/conversation.model';

@Injectable({ providedIn: 'root' })

export class UtilisateurService {

    utilisateurList : Utilisateur[]=[]

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

  getUtilisateurs(id:number){
    return this.http
    .get('/api/utilisateur/'+id+'/listAll')
      .pipe(map(
          (resp:any) => {
              console.log(resp);
              this.utilisateurList = resp.response
              return this.utilisateurList
          }));
  }
}
