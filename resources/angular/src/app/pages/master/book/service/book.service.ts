import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
    providedIn: 'root'
})
export class BookService {

    constructor(private landaServ: LandaService) { }

    getBooks(arrParameter) {
        return this.landaServ.DataGet('/v1/books', arrParameter);
    }

    getBookById(bookId) {
        return this.landaServ.DataGet('/v1/books/' + bookId);
    }

    createBook(payload) {
        return this.landaServ.DataPost('/v1/books', payload);
    }

    updateBook(payload) {
        return this.landaServ.DataPut('/v1/books', payload);
    }

    deleteBook(bookId) {
        return this.landaServ.DataDelete('/v1/books/' + bookId);
    }


}
