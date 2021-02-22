import { Observable, BehaviorSubject, throwError } from 'rxjs';
import { map, catchError, retry } from 'rxjs/operators';
import { HttpClient, HttpHeaders, HttpErrorResponse, JsonpClientBackend } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Utilisateur } from '../models/utilisateur.model';


@Injectable({ providedIn: 'root' })

export class AuthService {


    public currentUser: Observable<Utilisateur>;
    private currentUserSubject: BehaviorSubject<Utilisateur>;
    currentUserValue: any;

    constructor(
    private router: Router,
    private http: HttpClient
    ) { 
        this.currentUserSubject = new BehaviorSubject<Utilisateur>(JSON.parse(localStorage.getItem('currentUser')));
        this.currentUser = this.currentUserSubject.asObservable();
    }

    // Http Options
    // httpOptions = {
    //     headers: new HttpHeaders({
    //     'Content-Type': 'application/json'
    //     })
    // };
    httpOptions = {
      headers: new HttpHeaders({ 
        'Access-Control-Allow-Origin':'*',
        
      })
    };

   

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

  register(data:Utilisateur){
    return this.http
    .post<any>('/api/auth/register', data)
    .pipe(map(
      (resp) => {
        console.log(resp);
        // store Utilisateur details and jwt token in local storage to keep Utilisateur logged in between page refreshes
        localStorage.setItem('token', resp.response);
        this.currentUserSubject.next(resp.response);
        return resp;
    }));
  }

    login(addMail: string, mdp: string) {
        
      let params = {
          "addMail":addMail,
          "mdp":mdp
      }

      return this.http
      .post<any>('/api/auth/login', params)
        .pipe(map(
          (resp) => {
            console.log(resp);
            // store Utilisateur details and jwt token in local storage to keep Utilisateur logged in between page refreshes
            localStorage.setItem('token', resp.response);
            this.currentUserSubject.next(resp.response);

            return resp;
          }
        )
      );

    }

    isLoggedIn(){
        return localStorage.getItem('token') != null;
    }

    // After clearing localStorage redirect to login screen
  logout() {
    localStorage.clear();
    this.router.navigate(['/connexion']);
    this.currentUserSubject.next(null);
  }
}