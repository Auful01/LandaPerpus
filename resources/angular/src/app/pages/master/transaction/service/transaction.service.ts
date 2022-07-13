import { Injectable } from '@angular/core';
import { LandaService } from 'src/app/core/services/landa.service';

@Injectable({
    providedIn: 'root'
})
export class TransactionService {

    constructor(private landaServ: LandaService) { }

    getTransactions(arrParameter) {
        return this.landaServ.DataGet('/v1/transactions', { arrParameter });
    }

    getTransactionById(transactionId) {
        return this.landaServ.DataGet('/v1/transactions/' + transactionId);
    }

    createTransaction(payload) {
        return this.landaServ.DataPost('/v1/transactions', payload);
    }

    updateTransaction(payload) {
        return this.landaServ.DataPut('/v1/transactions', payload);
    }

    deleteTransaction(transactionId) {
        return this.landaServ.DataDelete('/v1/transactions/' + transactionId);
    }

    kembalikan(payload) {
        return this.landaServ.DataPost('/v1/transactions/kembali', payload);
    }

    getByLogin(arrParameter) {
        return this.landaServ.DataGet('/v1/transaksiku', arrParameter);
    }

}
